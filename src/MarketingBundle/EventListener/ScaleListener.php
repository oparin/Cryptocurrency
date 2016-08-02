<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/31/16
 * Time: 12:09 PM
 */

namespace MarketingBundle\EventListener;
use Doctrine\ORM\EntityManager;
use MarketingBundle\Event\ScaleEvent;
use StatisticBundle\Entity\ScaleBonusStatistic;
use UserBundle\Entity\User;

/**
 * Class ScaleListener
 * @package MarketingBundle\EventListener
 */
class ScaleListener
{
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param ScaleEvent $event
     */
    public function addUserInScale(ScaleEvent $event)
    {
        $user       = $event->getUser();
        $status     = $event->getStatus();

        if ($user->getId() != 1) {
            $sponsor = $this->searchSponsor($user);
            $user->setFather($sponsor);

            $this->em->flush();

            $user   = $event->getUser();
//            while ($father = $user->getFather()) {
//                $father->getCareer()->setOverallVolume($father->getCareer()->getOverallVolume() + $status->getPrice());
//                $user = $father;
//            }

            $this->em->flush();
        }
    }

    /**
     * @param User $user
     *
     * @return User
     */
    protected function searchSponsor(User $user)
    {
        if ($user->getSponsor()) {
            $sponsor = $user->getSponsor();
            if ($sponsor->getFather()) {
                return $sponsor;
            } else {
                return $this->searchSponsor($sponsor);
            }
        } else {
            return $this->em->getRepository('UserBundle:User')->find(1);
        }
    }
}
