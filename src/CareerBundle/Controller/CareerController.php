<?php

namespace CareerBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CareerController extends Controller
{
    /**
     * @return array
     *
     * @Route("/career", name="office_career")
     * @Template("CareerBundle::career.html.twig")
     */
    public function indexAction()
    {
        /** @var $em */
        $em = $this->getDoctrine()->getManager();

        $ranks = $em->getRepository('AdminCareerBundle:Rank')->findAll();
        $members = array();
        foreach ($ranks as $rank) {
            $referrals = $em->getRepository('UserBundle:User')->findBy(array(
                'father' => $this->getUser(),
                'rank'   => $rank,
            ));
            $members[] = array('name' => $rank->getName(), 'refs' => count($referrals));
        }

        return array(
            'members'   => $members,
        );
    }

    /**
     * @return array
     *
     * @Route("/career-rewards", name="office_career_rewards")
     * @Template("CareerBundle::career_rewards.html.twig")
     */
    public function careerRewardsAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $stats = $em->getRepository('AdminCareerBundle:SuccessRank')->findBy(array(
            'user'      => $this->getUser(),
            'status'    => true,
        ));

        return array(
            'stats' => $stats,
        );
    }
}
