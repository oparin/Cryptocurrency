<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/16/16
 * Time: 4:01 PM
 */

namespace Admin\CareerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class SuccessRank
 * @package Admin\CareerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="success_ranks")
 */
class SuccessRank
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="ranks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CareerBundle\Entity\Rank", inversedBy="history")
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rank;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $status = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

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
     * Set status
     *
     * @param boolean $status
     *
     * @return SuccessRank
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SuccessRank
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return SuccessRank
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
     * Set rank
     *
     * @param \Admin\CareerBundle\Entity\Rank $rank
     *
     * @return SuccessRank
     */
    public function setRank(Rank $rank = null)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return \Admin\CareerBundle\Entity\Rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return SuccessRank
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
