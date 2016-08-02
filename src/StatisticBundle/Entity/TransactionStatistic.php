<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 9:41 AM
 */

namespace StatisticBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Class TransactionStatistic
 * @package StatisticBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="transaction_statistic")
 */
class TransactionStatistic
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="transactionStatistic")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     *
     * 0 - withdraw
     * 1 - deposit
     * 2 - buy status
     * 3 - buy debt
     * 4 - convert units
     * 5 - profit units
     * 6 - refund founds
     */
    protected $type;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $sum;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_wallet")
     */
    protected $mainWallet;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_account")
     */
    protected $mainAccount;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_credit")
     */
    protected $mainCredit;

    /**
     * @ORM\Column(type="decimal", scale=2, name="main_profit")
     */
    protected $mainProfit;

    /**
     * TransactionStatistic constructor.
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
     * @return TransactionStatistic
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
     * Set type
     *
     * @param integer $type
     *
     * @return TransactionStatistic
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sum
     *
     * @param string $sum
     *
     * @return TransactionStatistic
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
     * Set mainWallet
     *
     * @param string $mainWallet
     *
     * @return TransactionStatistic
     */
    public function setMainWallet($mainWallet)
    {
        $this->mainWallet = $mainWallet;

        return $this;
    }

    /**
     * Get mainWallet
     *
     * @return string
     */
    public function getMainWallet()
    {
        return $this->mainWallet;
    }

    /**
     * Set mainAccount
     *
     * @param string $mainAccount
     *
     * @return TransactionStatistic
     */
    public function setMainAccount($mainAccount)
    {
        $this->mainAccount = $mainAccount;

        return $this;
    }

    /**
     * Get mainAccount
     *
     * @return string
     */
    public function getMainAccount()
    {
        return $this->mainAccount;
    }

    /**
     * Set mainCredit
     *
     * @param string $mainCredit
     *
     * @return TransactionStatistic
     */
    public function setMainCredit($mainCredit)
    {
        $this->mainCredit = $mainCredit;

        return $this;
    }

    /**
     * Get mainCredit
     *
     * @return string
     */
    public function getMainCredit()
    {
        return $this->mainCredit;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return TransactionStatistic
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
     * Set mainProfit
     *
     * @param string $mainProfit
     *
     * @return TransactionStatistic
     */
    public function setMainProfit($mainProfit)
    {
        $this->mainProfit = $mainProfit;

        return $this;
    }

    /**
     * Get mainProfit
     *
     * @return string
     */
    public function getMainProfit()
    {
        return $this->mainProfit;
    }
}
