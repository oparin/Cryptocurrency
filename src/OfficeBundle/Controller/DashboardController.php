<?php

namespace OfficeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\User;

class DashboardController extends Controller
{
    /**
     * @return array
     *
     * @Route("/", name="office_dashboard")
     * @Template("OfficeBundle:Dashboard:dashboard.html.twig")
     */
    public function dashboardAction()
    {
        /** @var $user User */
        $user = $this->getUser();

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AdminNewsBundle:News')->findBy(array(), array('id' => 'DESC'));

        $totalReferrals = $em->getRepository('UserBundle:User')->getCountReferrals($user);

        $qb = $em->getRepository('StatisticBundle:SponsorBonusStatistic')->createQueryBuilder('sbs');
        $qb
            ->select('SUM(sbs.bonus)')
            ->leftJoin('sbs.user', 's')
            ->andWhere('s.sponsor = :user')
            ->setParameter('user', $user);
        $directBonus = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $qb = $em->getRepository('StatisticBundle:PointsStatistic')->createQueryBuilder('ps');
        $qb
            ->select('SUM(ps.bonus)')
            ->where('ps.user = :user')
            ->setParameter('user', $user);
        $binaryBonus = ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;

        $settings = $em->getRepository('AdminCreditBundle:CreditSettings')->findOneBy(array());

        $qb = $em->getRepository('AdminCreditBundle:Statistic')->createQueryBuilder('s');
        $qb
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(7);
        $statisticRate = $qb->getQuery()->getResult();

        return array(
            'news'  => $news,
            'total_referrals'   => $totalReferrals,
            'direct_bonus'      => $directBonus,
            'binary_bonus'      => $binaryBonus,
            'settings'          => $settings,
            'statistic_rate'    => array_reverse($statisticRate),
            'tickets'           => $user->getSupportTickets(),
        );
    }
}
