<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/10/16
 * Time: 12:15 PM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class ScaleBonusStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="scale_bonus_statistic")
 */
class ScaleBonusStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $userFrom;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="scaleBonus")
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $userTo;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $bonus;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ScaleBonusStatistic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set bonus
     *
     * @param string $bonus
     *
     * @return ScaleBonusStatistic
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus
     *
     * @return string
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set userFrom
     *
     * @param \UserBundle\Entity\User $userFrom
     *
     * @return ScaleBonusStatistic
     */
    public function setUserFrom(User $userFrom = null)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return \UserBundle\Entity\User
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Set userTo
     *
     * @param \UserBundle\Entity\User $userTo
     *
     * @return ScaleBonusStatistic
     */
    public function setUserTo(User $userTo = null)
    {
        $this->userTo = $userTo;

        return $this;
    }

    /**
     * Get userTo
     *
     * @return \UserBundle\Entity\User
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return ScaleBonusStatistic
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }
}
