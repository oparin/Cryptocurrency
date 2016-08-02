<?php

namespace WalletBundle\Controller;

use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;

/**
 * Class CredittController
 * @package WalletBundle\Controller
 *
 * @Route("/wallets")
 */
class CreditController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/credits", name="wallets_credits")
     * @Template("WalletBundle:Credit:credits.html.twig")
     */
    public function indexAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $translator = $this->get('translator');

        /** @var $user User */
        $user       = $this->getUser();
        $wallets    = $user->getWallets();
        $accounts   = $user->getAccounts();
        $credits    = $user->getCredits();
        $profits    = $user->getProfits();
        $settings   = $em->getRepository('AdminCreditBundle:CreditSettings')->findOneBy(array());

        $payDebtForm = $this->get('form.factory')->createNamedBuilder('pay_debt_form')
            ->add('account', 'choice', array(
                'choices'   => array('1' => $translator->trans('office.dashboard.main_wallet'), '2' => $translator->trans('office.dashboard.main_account')),
            ))
            ->add('sum', 'money', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        $convertForm = $this->get('form.factory')->createNamedBuilder('convert_form')
            ->add('sum', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $dispatcher = $this->get('event_dispatcher');
            if ($request->request->has('pay_debt_form')) {
                $payDebtForm->handleRequest($request);
                if ($payDebtForm->isValid()) {
                    $type = $payDebtForm->get('account')->getData();
                    $sum  = $payDebtForm->get('sum')->getData();

                    switch ($type) {
                        case '1':
                            $account = $wallets[0];
                            break;
                        case '2':
                            $account = $accounts[0];
                            break;
                        default:
                            $account = $accounts[0];
                            break;
                    }

                    if ($account->getSum() >= $sum) {
                        if ($sum > $user->getDebt()) {
                            $account->setSum($account->getSum() - $user->getDebt());
                            $user->setDebt(0);
                        } else {
                            $account->setSum($account->getSum() - $sum);
                            $user->setDebt($user->getDebt() - $sum);
                        }
                        $em->flush();

                        $event = new TransactionEvent($user, $sum, $wallets[0]->getSum(), $accounts[0]->getSum(), $credits[0]->getSum(), $profits[0]->getSum(), 3);
                        $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                        $this->addFlash('success', $translator->trans('office.wallets.pay_debt_success'));

                        return $this->redirectToRoute('wallets_credits');
                    } else {
                        $payDebtForm->get('sum')->addError(new FormError($translator->trans('office.wallets.no_funds')));
                    }
                }
            }

            if ($request->request->has('convert_form')) {
                $convertForm->handleRequest($request);
                if ($convertForm->isValid()) {
                    if ($user->getDebt() <= 0) {
                        $sum = $convertForm->get('sum')->getData();
                        $maxSum = $credits[0]->getSum() * $settings->getPercentConvert() / 100;
                        if ($sum <= $maxSum) {
                            $convert = false;
                            $transaction = $em->getRepository('StatisticBundle:TransactionStatistic')->findOneBy(array(
                                'user'  => $user,
                                'type'  => 4,
                            ), array('id' => 'DESC'));
                            if ($transaction) {
                                $date = new \DateTime();
                                $convertDay = $transaction->getDate();
                                if ($date > $convertDay->modify('+ '.$settings->getPeriodConvert().' day')) {
                                    $convert = true;
                                }
                            } else {
                                $convert = true;
                            }

                            if ($convert) {
                                if ($user->getVerificationStatus() == 2) {
                                    $credits[0]->setSum($credits[0]->getSum() - $sum);
                                    $wallets[0]->setSum($wallets[0]->getSum() + $sum * $settings->getRate());
                                    $em->flush();

                                    $event = new TransactionEvent($user, $sum, $wallets[0]->getSum(), $accounts[0]->getSum(), $credits[0]->getSum(), $profits[0]->getSum(), 4);
                                    $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);

                                    $this->addFlash('success', $translator->trans('office.wallets.convert_success'));

                                    return $this->redirectToRoute('wallets_credits');
                                } else {
                                    $this->addFlash('error', $translator->trans('office.wallets.verificaton_error'));
                                }
                            } else {
                                $this->addFlash('error', $translator->trans('office.wallets.period_error', array('%days%' => $settings->getPeriodConvert())));
                            }
                        } else {
                            $convertForm->get('sum')->addError(new FormError($translator->trans('office.wallets.error_sum')));
                        }
                    } else {
                        $this->addFlash('error', $translator->trans('office.wallets.debt_error'));
                    }
                }
            }
        }

        return array(
            'pay_deb_form'  => $payDebtForm->createView(),
            'convert_form'  => $convertForm->createView(),
            'wallet'        => $wallets[0],
            'account'       => $accounts[0],
            'settings'      => $settings,
        );
    }
}
