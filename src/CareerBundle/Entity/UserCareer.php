<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/6/16
 * Time: 4:29 PM
 */

namespace CareerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class UserCareer
 * @package CareerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_career")
 */
class UserCareer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="career")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\Column(type="integer", name="left_points")
     */
    protected $leftPoints = 0;

    /**
     * @ORM\Column(type="integer", name="rights_points")
     */
    protected $rightPoints = 0;

    /**
     * @ORM\Column(type="integer", name="overall_volume ")
     */
    protected $overallVolume = 0;

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
     * Set leftPoints
     *
     * @param integer $leftPoints
     *
     * @return UserCareer
     */
    public function setLeftPoints($leftPoints)
    {
        $this->leftPoints = $leftPoints;

        return $this;
    }

    /**
     * Get leftPoints
     *
     * @return integer
     */
    public function getLeftPoints()
    {
        return $this->leftPoints;
    }

    /**
     * Set rightPoints
     *
     * @param integer $rightPoints
     *
     * @return UserCareer
     */
    public function setRightPoints($rightPoints)
    {
        $this->rightPoints = $rightPoints;

        return $this;
    }

    /**
     * Get rightPoints
     *
     * @return integer
     */
    public function getRightPoints()
    {
        return $this->rightPoints;
    }

    /**
     * Set overallVolume
     *
     * @param integer $overallVolume
     *
     * @return UserCareer
     */
    public function setOverallVolume($overallVolume)
    {
        $this->overallVolume = $overallVolume;

        return $this;
    }

    /**
     * Get overallVolume
     *
     * @return integer
     */
    public function getOverallVolume()
    {
        return $this->overallVolume;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserCareer
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
