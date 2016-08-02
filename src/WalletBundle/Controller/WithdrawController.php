<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/3/16
 * Time: 11:17 AM
 */

namespace WalletBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;
use WalletBundle\Event\WalletEvent;
use WalletBundle\Grid\Column\StatusColumn;
use WalletBundle\WalletEvents;

/**
 * Class WithdrawController
 * @package WalletBundle\Controller
 *
 * @Route("/withdraw")
 */
class WithdrawController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/withdraw", name="withdraw_withdraw")
     * @Template("WalletBundle:Withdraw:withdraw_withdraw.html.twig")
     */
    public function withdrawAction(Request $request)
    {
        $translator = $this->get('translator');

        /** @var $user User */
        $user       = $this->getUser();
        $wallets    = $user->getWallets();
        $accounts   = $user->getAccounts();
        $credits    = $user->getCredits();
        $profits    = $user->getProfits();

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings       = $em->getRepository('AdminCreditBundle:CreditSettings')->findOneBy(array());
        $mainSettings   = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

        $form = $this->createFormBuilder()
            ->add('wallet', 'choice', array(
                'choices'   => array('1' => $translator->trans('office.dashboard.main_wallet'), '2' => $translator->trans('office.dashboard.units_profit')),
            ))
            ->add('sum', 'money', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('account', 'text', array(
                'constraints' => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $type = $form->get('wallet')->getData();
                $sum  = $form->get('sum')->getData();

                if ($sum >= $mainSettings->getMinWithdraw()) {
                    $withdraw = false;
                    switch ($type) {
                        case '1':
                            $account = $wallets[0];
                            $withdraw = true;
                            $typeWithdraw = 0;
                            $maxSum = $wallets[0]->getSum();
                            break;
                        case '2':
                            if ($user->getDebt() <= 0) {
                                $transaction = $em->getRepository('StatisticBundle:WalletStatistic')->findOneBy(array(
                                    'user' => $user,
                                    'type' => 0,
                                    'typeWithdraw' => 1,
                                ), array('id' => 'DESC'));
                                if ($user->getVerificationStatus() == 2) {
                                    if ($transaction) {
                                        $date = new \DateTime();
                                        $convertDay = $transaction->getDate();
                                        if ($date > $convertDay->modify('+ '.$settings->getPeriodWithdraw().' day')) {
                                            $withdraw = true;
                                            $typeWithdraw = 1;
                                            $account = $profits[0];
                                            $maxSum = $profits[0]->getSum() * $settings->getPercentWithdraw() / 100;
                                        } else {
                                            $this->addFlash('error', $translator->trans('office.withdraw.period_error', array('%days%' => $settings->getPeriodWithdraw())));
                                        }
                                    } else {
                                        $withdraw = true;
                                        $typeWithdraw = 1;
                                        $account = $profits[0];
                                        $maxSum = $profits[0]->getSum() * $settings->getPercentWithdraw() / 100;
                                    }
                                } else {
                                    $this->addFlash('error', $translator->trans('office.wallets.verificaton_error'));
                                }
                            } else {
                                $this->addFlash('error', $translator->trans('office.withdraw.debt_error'));
                            }
                            break;
                        default:
                            $account = $wallets[0];
                            $withdraw = true;
                            $typeWithdraw = 0;
                            $maxSum = $wallets[0]->getSum();
                            break;
                    }

                    if ($withdraw) {
                        if ($sum <= $maxSum) {
                            $account->setSum($account->getSum() - $sum);
                            $em->flush();

                            $event = new WalletEvent($user, $sum, 'Bitcoin', $typeWithdraw, $form->get('account')->getData());
                            $dispatcher = $this->get('event_dispatcher');
                            $dispatcher->dispatch(WalletEvents::PAYOUT_WALLET, $event);

                            $event = new TransactionEvent($user, $sum, $wallets[0]->getSum(), $accounts[0]->getSum(), $credits[0]->getSum(), $profits[0]->getSum(), 0);
                            $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                            $this->addFlash('success', $translator->trans('office.withdraw.withdraw_success'));

                            return $this->redirectToRoute('withdraw_withdraw');
                        } else {
                            $form->get('sum')->addError(new FormError($translator->trans('office.withdraw.error_sum')));
                        }
                    }
                } else {
                    $form->get('sum')->addError(new FormError($translator->trans('office.withdraw.min_sum', array('%sum%' => $mainSettings->getMinWithdraw()))));
                }
            }
        }

        return array(
            'form'      => $form->createView(),
            'wallet'    => $wallets[0],
            'profit'    => $profits[0],
            'percent'   => $settings->getPercentWithdraw(),
        );
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/statistic", name="withdraw_statistic")
     * @Template("WalletBundle:Withdraw:withdraw_statistic.html.twig")
     */
    public function withdrawStatisticAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $source = new Entity('StatisticBundle:WalletStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->andWhere($tableAlias.'.type = false')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'type',
            'status',
            'hash',
            'system',
            'typeWithdraw',
        ));

        $translator = $this->get('translator');

        $statusColumn = new StatusColumn(array(
            'id'        => 'status',
            'title'     => $translator->trans('office.withdraw.status'),
        ));
        $grid->addColumn($statusColumn);



        $grid->getColumn('date')->setTitle($translator->trans('office.withdraw.date'));
        $grid->getColumn('sum')->setTitle($translator->trans('office.withdraw.sum'));
        $grid->getColumn('account')->setTitle($translator->trans('office.withdraw.account'));

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}
