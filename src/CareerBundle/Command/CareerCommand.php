<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/7/16
 * Time: 2:45 PM
 */

namespace CareerBundle\Command;

use Admin\CareerBundle\Entity\SuccessRank;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Entity\User;

/**
 * Class CareerCommand
 * @package CareerBundle\Command
 */
class CareerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('career:start')
            ->setDescription('Start Career');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $em EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $qb = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->where('u.status IS NOT NULL')
            ->andWhere('c.overallVolume > 0')
            ->leftJoin('u.career', 'c');
        $members = $qb->getQuery()->getResult();

        $count = 0;
        $date = new \DateTime();
        if ($members) {
            $ranks = $em->getRepository('AdminCareerBundle:Rank')->findBy(array(), array('id' => 'DESC'));

            /** @var $member User */
            foreach ($members as $member) {
                $career = $member->getCareer();
                foreach ($ranks as $rank) {
                    if ($career->getLeftPoints() < $career->getRightPoints()) {
                        $weakFoot = $career->getLeftPoints();
                    } else {
                        $weakFoot = $career->getRightPoints();
                    }
                    if ($weakFoot >= $rank->getWeakFoot() && $career->getOverallVolume() >= $rank->getOverallVolume()) {
                        $referrals = $em->getRepository('UserBundle:User')->findBy(array(
                            'father' => $member,
                            'rank'   => $rank->getRank(),
                        ));
                        if (count($referrals) >= $rank->getCountReferrals()) {
                            if (!$member->getRank() || $member->getRank()->getId() < $rank->getId()) {
                                $member->setRank($rank);
                                $statistic = new SuccessRank();
                                $statistic->setUser($member);
                                $statistic->setRank($rank);
                                $statistic->setDate($date);
                                $em->persist($statistic);
                                $count++;
                                break;
                            }
                        }
                    }
                }
                $career->setLeftPoints(0);
                $career->setRightPoints(0);
                $career->setOverallVolume(0);
                $em->flush();
            }
        }
        $output->writeln(count($count).' users');
    }
}
