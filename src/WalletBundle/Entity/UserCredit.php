<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/18/16
 * Time: 10:43 AM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class UserCurrency
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_credits")
 */
class UserCredit
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="credits")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="WalletBundle\Entity\TypeBalance", inversedBy="credits")
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
     * @return UserCredit
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
     * @return UserCredit
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
     * @return UserCredit
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
