<?php

namespace Admin\CreditBundle\Controller;

use Admin\CreditBundle\Entity\Statistic;
use Admin\CreditBundle\Form\Type\CreditSettingsFormType;
use Doctrine\ORM\EntityManager;
use StatisticBundle\Event\TransactionEvent;
use StatisticBundle\StatisticEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Class CreditController
 * @package Admin\CreditBundle\Controller
 */
class CreditController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/settings", name="credits_settings")
     * @Template("AdminCreditBundle::credits_settings.html.twig")
     */
    public function indexAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AdminCreditBundle:CreditSettings')->findOneBy(array());

        $form = $this->createForm(new CreditSettingsFormType(), $settings);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();

                $statistic = new Statistic();
                $statistic->setRate($form->get('rate')->getData());
                $statistic->setDate(new \DateTime());
                $em->persist($statistic);

                $em->flush();

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('saved')
                );

                return $this->redirectToRoute('credits_settings');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/calculate-percent", name="calculate_percent")
     * @Template("AdminCreditBundle::calculate_percent.html.twig")
     */
    public function calculatePercentAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
            $qb
                ->where('c.sum > 0')
                ->leftJoin('u.credits', 'c');
            $users = $qb->getQuery()->getResult();

            $settings = $em->getRepository('AdminCreditBundle:CreditSettings')->findOneBy(array());
            $dispatcher = $this->get('event_dispatcher');

            /** @var $user User */
            foreach ($users as $user) {
                $wallets    = $user->getWallets();
                $accounts   = $user->getAccounts();
                $credits    = $user->getCredits();
                $profits    = $user->getProfits();

                $sum = $credits[0]->getSum() * $settings->getPercentProfit() / 100;
                $profits[0]->setSum($profits[0]->getSum() + $sum);
                $event = new TransactionEvent($user, $sum, $wallets[0]->getSum(), $accounts[0]->getSum(), $credits[0]->getSum(), $profits[0]->getSum(), 5);
                $dispatcher->dispatch(StatisticEvents::TRANSACTION, $event);
            }
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('saved')
            );

            return $this->redirectToRoute('calculate_percent');
        }

        return array();
    }
}
