<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/4/14
 * Time: 5:34 PM
 */

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class Binary
 *
 * @package Lottery\BinaryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_binary")
 */
class Binary
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="binary")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_left", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $left;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_right", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $right;

    /**
     * 0 - left
     * 1 - right
     * @ORM\Column(type="boolean")
     */
    protected $course = false;

    /**
     * @ORM\Column(type="integer", name="left_points")
     */
    protected $leftPoints = 0;

    /**
     * @ORM\Column(type="integer", name="rights_points")
     */
    protected $rightPoints = 0;

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
     * Set course
     *
     * @param boolean $course
     *
     * @return Binary
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return boolean
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set leftPoints
     *
     * @param integer $leftPoints
     *
     * @return Binary
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
     * @return Binary
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Binary
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

    /**
     * Set left
     *
     * @param \UserBundle\Entity\User $left
     *
     * @return Binary
     */
    public function setLeft(User $left = null)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Get left
     *
     * @return \UserBundle\Entity\User
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Set right
     *
     * @param \UserBundle\Entity\User $right
     *
     * @return Binary
     */
    public function setRight(User $right = null)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Get right
     *
     * @return \UserBundle\Entity\User
     */
    public function getRight()
    {
        return $this->right;
    }
}
