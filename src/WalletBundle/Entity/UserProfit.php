<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/2/16
 * Time: 9:43 AM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class UserProfit
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_profits")
 */
class UserProfit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="profit")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="WalletBundle\Entity\TypeBalance", inversedBy="profit")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum = 0.00;

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
     * Set sum
     *
     * @param string $sum
     *
     * @return UserProfit
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return string
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return UserProfit
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
     * Set type
     *
     * @param \WalletBundle\Entity\TypeBalance $type
     *
     * @return UserProfit
     */
    public function setType(TypeBalance $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \WalletBundle\Entity\TypeBalance
     */
    public function getType()
    {
        return $this->type;
    }
}
