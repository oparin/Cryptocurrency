<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 17:54
 */

namespace SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class SupportTicket
 * @package SupportBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="support_tickets")
 */
class SupportTicket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="supportTickets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * 0 - Open ticket
     * 1 - Answered
     * 2 - Closed
     *
     * @ORM\Column(type="smallint")
     */
    protected $status = 0;

    /**
     * @ORM\OneToMany(targetEntity="SupportBundle\Entity\ReplySupportTicket", mappedBy="ticket", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $answers;

    /**
     * SupportTicket constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
     * @return SupportTicket
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
     * Set subject
     *
     * @param string $subject
     *
     * @return SupportTicket
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return SupportTicket
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return SupportTicket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return SupportTicket
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
     * Add answer
     *
     * @param \SupportBundle\Entity\ReplySupportTicket $answer
     *
     * @return SupportTicket
     */
    public function addAnswer(ReplySupportTicket $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \SupportBundle\Entity\ReplySupportTicket $answer
     */
    public function removeAnswer(ReplySupportTicket $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
