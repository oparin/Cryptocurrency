<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/8/14
 * Time: 11:38 AM
 */

namespace MarketingBundle\EventListener;

use Admin\MarketingBundle\Entity\BinaryProfit;
use Doctrine\ORM\EntityManager;
use MarketingBundle\Entity\Binary;
use MarketingBundle\Event\BinaryEvent;
use UserBundle\Entity\User;

/**
 * Class BinaryListener
 *
 * @package MarketingBundle\EventListener
 */
class BinaryListener
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
     * @param BinaryEvent $event
     */
    public function createNewBinary(BinaryEvent $event)
    {
        $user       = $event->getUser();
        $sponsor    = $this->searchSponsor($user);

        $qb = $this->em->getRepository('MarketingBundle:Binary')->createQueryBuilder('b');
        $qb
            ->where('b.left = :user')
            ->orWhere('b.right = :user')
            ->setParameter('user', $sponsor);

        /* @var $sponsorBinary Binary */
        $sponsorBinary = $qb->getQuery()->getOneOrNullResult();

        if (!$sponsorBinary) {
            $sponsorBinary = $sponsor->getBinary();
        }

        if ($this->em->getRepository('UserBundle:User')->getCountReferrals($sponsor) == 1) {
            if ($sponsorBinary->getLeft() === $sponsor) {
                $binary = $this->searchPlaceLeft($sponsor->getBinary());
                $binary->setLeft($user);
            } elseif ($sponsorBinary->getRight() === $sponsor) {
                $binary = $this->searchPlaceRight($sponsor->getBinary());
                $binary->setRight($user);
            } else {
                $binary = $this->searchPlaceLeft($sponsorBinary);
                $binary->setLeft($user);
            }

        } elseif ($this->em->getRepository('UserBundle:User')->getCountReferrals($sponsor) == 2) {
            if ($sponsorBinary->getLeft() === $sponsor) {
                $binary = $this->searchPlaceRight($sponsor->getBinary());
                $binary->setRight($user);
            } elseif ($sponsorBinary->getRight() === $sponsor) {
                $binary = $this->searchPlaceLeft($sponsor->getBinary());
                $binary->setLeft($user);
            } else {
                $binary = $this->searchPlaceRight($sponsorBinary);
                $binary->setRight($user);
            }
        } else {
            if (!$sponsor->getBinary()->getCourse()) {
                $binary = $this->searchPlaceLeft($sponsor->getBinary());
                $binary->setLeft($user);
            } elseif ($sponsor->getBinary()->getCourse()) {
                $binary = $this->searchPlaceRight($sponsor->getBinary());
                $binary->setRight($user);
            }
        }

        if (!$user->getBinary()) {
            $userBinary = new Binary();
            $userBinary->setUser($user);
            $this->em->persist($userBinary);
        }

        $this->em->flush();
    }

    /**
     * @param User $user
     *
     * @return User
     */
    protected function searchSponsor(User $user)
    {
        if ($user->getBinary()) {
            return $user;
        } else {
            if (!$this->em->getRepository('MarketingBundle:Binary')->findAll()) {
                return $user;
            }
        }

        if ($user->getSponsor()) {
            return $this->searchSponsor($user->getSponsor());
        } else {
            $us = $this->em->getRepository('UserBundle:User')->find(1);

            return $this->searchSponsor($us);
        }
    }

    /**
     * @param Binary $binary
     *
     * @return Binary
     */
    protected function searchPlaceLeft(Binary $binary)
    {
        if (!$binary->getLeft()) {
            return $binary;
        }

        return $this->searchPlaceLeft($binary->getLeft()->getBinary());
    }

    /**
     * @param Binary $binary
     *
     * @return Binary
     */
    protected function searchPlaceRight(Binary $binary)
    {
        if (!$binary->getRight()) {
            return $binary;
        }

        return $this->searchPlaceRight($binary->getRight()->getBinary());
    }

    /**
     * @param BinaryEvent $event
     */
    public function setPoints(BinaryEvent $event)
    {
        $user           = $event->getUser();
        $userStatus     = $user->getStatus();

        do {
            $qb = $this->em->getRepository('MarketingBundle:Binary')->createQueryBuilder('b');
            $qb
                ->where('b.left = :user')
                ->orWhere('b.right = :user')
                ->setParameter('user', $user);
            /* @var $sponsorBinary Binary */
            $sponsorBinary = $qb->getQuery()->getOneOrNullResult();

            if ($sponsorBinary) {
                $father = $sponsorBinary->getUser();
                $fatherStatus = $father->getStatus();

                /* @var $binaryProfit BinaryProfit */
                $binaryProfit = $this->em->getRepository('AdminMarketingBundle:BinaryProfit')->findOneBy(array(
                    'statusFrom'    => $fatherStatus,
                    'statusTo'      => $userStatus,
                ));

                if ($binaryProfit) {
                    $bonus = $binaryProfit->getPoints();

                    if ($father->getBinary()->getLeft() == $user) {
                        $father->getBinary()->setLeftPoints($father->getBinary()->getLeftPoints() + $bonus);
                        $father->getCareer()->setLeftPoints($father->getCareer()->getLeftPoints() + $bonus);
                    } elseif ($father->getBinary()->getRight() == $user) {
                        $father->getBinary()->setRightPoints($father->getBinary()->getRightPoints() + $bonus);
                        $father->getCareer()->setRightPoints($father->getCareer()->getRightPoints() + $bonus);
                    }
                }
                $user = $father;
            }
        } while ($sponsorBinary);

        $this->em->flush();
    }
}
