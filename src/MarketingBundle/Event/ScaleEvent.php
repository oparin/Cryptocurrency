<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/31/16
 * Time: 12:03 PM
 */

namespace MarketingBundle\Event;

use Admin\SettingsBundle\Entity\MemberStatus;
use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;

/**
 * Class ScaleEvent
 * @package MarketingBundle\Event
 */
class ScaleEvent extends Event
{
    protected $user;
    protected $status;

    /**
     * ScaleEvent constructor.
     * @param User         $user
     * @param MemberStatus $status
     */
    public function __construct(User $user, MemberStatus $status)
    {
        $this->user     = $user;
        $this->status   = $status;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return MemberStatus
     */
    public function getStatus()
    {
        return $this->status;
    }
}