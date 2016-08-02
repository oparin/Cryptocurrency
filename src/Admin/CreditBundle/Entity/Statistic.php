<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/13/16
 * Time: 12:30 PM
 */

namespace Admin\CreditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Statistic
 * @package Admin\CreditBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="credits_statistic")
 */
class Statistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $rate;

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
     * @return Statistic
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
     * Set rate
     *
     * @param string $rate
     *
     * @return Statistic
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }
}
