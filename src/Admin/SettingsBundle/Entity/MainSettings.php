<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 10:02
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class MainSettings
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="main_settings")
 */
class MainSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="host_name")
     */
    protected $hostName;

    /**
     * @ORM\Column(type="decimal", scale=2, name="registration_fee")
     */
    protected $registrationFee;

    /**
     * @ORM\Column(type="decimal", scale=2, name="min_withdraw")
     */
    protected $minWithdraw;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hostName
     *
     * @param string $hostName
     *
     * @return MainSettings
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;

        return $this;
    }

    /**
     * Get hostName
     *
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * Set registrationFee
     *
     * @param string $registrationFee
     *
     * @return MainSettings
     */
    public function setRegistrationFee($registrationFee)
    {
        $this->registrationFee = $registrationFee;

        return $this;
    }

    /**
     * Get registrationFee
     *
     * @return string
     */
    public function getRegistrationFee()
    {
        return $this->registrationFee;
    }

    /**
     * Set minWithdraw
     *
     * @param string $minWithdraw
     *
     * @return MainSettings
     */
    public function setMinWithdraw($minWithdraw)
    {
        $this->minWithdraw = $minWithdraw;

        return $this;
    }

    /**
     * Get minWithdraw
     *
     * @return string
     */
    public function getMinWithdraw()
    {
        return $this->minWithdraw;
    }
}
