<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 22.03.16
 * Time: 10:24
 */

namespace SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ReplySupportTicket
 * @package SupportBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="reply_support_tickets")
 */
class ReplySupportTicket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SupportBundle\Entity\SupportTicket", inversedBy="answers")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $ticket;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * 0 - user
     * 1 - admin
     *
     * @ORM\Column(type="boolean")
     */
    protected $role;

    /**
     * ReplySupportTicket constructor.
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
     * @return ReplySupportTicket
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
     * Set text
     *
     * @param string $text
     *
     * @return ReplySupportTicket
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
     * Set role
     *
     * @param boolean $role
     *
     * @return ReplySupportTicket
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return boolean
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set ticket
     *
     * @param \SupportBundle\Entity\SupportTicket $ticket
     *
     * @return ReplySupportTicket
     */
    public function setTicket(SupportTicket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \SupportBundle\Entity\SupportTicket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
