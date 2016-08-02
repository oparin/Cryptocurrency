<?php

namespace UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return mixed
     */
    public function getCountReferrals(User $user)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('count(u.id)');
        $qb->where('u.sponsor = :user');
        $qb->setParameter('user', $user);

        return $qb->getQuery()->getSingleScalarResult();
    }
}