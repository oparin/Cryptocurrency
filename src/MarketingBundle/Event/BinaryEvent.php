<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/19/16
 * Time: 11:08 AM
 */

namespace MarketingBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class BinaryEvent
 * @package MarketingBundle\Event
 */
class BinaryEvent extends Event
{
    protected $user;

    /**
     * BinaryEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
