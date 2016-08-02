<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/16/15
 * Time: 11:26 AM
 */

namespace WalletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypeBalance
 * @package WalletBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="type_balances")
 */
class TypeBalance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserAccount", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWallet", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $wallets;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserCredit", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $credits;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserProfit", mappedBy="type", cascade={"persist", "remove"})
     */
    protected $profits;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->wallets  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->credits  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profits  = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return TypeBalance
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     *
     * @return TypeBalance
     */
    public function addAccount(UserAccount $account)
    {
        $this->accounts[] = $account;

        return $this;
    }

    /**
     * Remove account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     */
    public function removeAccount(UserAccount $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add wallet
     *
     * @param \WalletBundle\Entity\UserWallet $wallet
     *
     * @return TypeBalance
     */
    public function addWallet(UserWallet $wallet)
    {
        $this->wallets[] = $wallet;

        return $this;
    }

    /**
     * Remove wallet
     *
     * @param \WalletBundle\Entity\UserWallet $wallet
     */
    public function removeWallet(UserWallet $wallet)
    {
        $this->wallets->removeElement($wallet);
    }

    /**
     * Get wallets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWallets()
    {
        return $this->wallets;
    }

    /**
     * Add credit
     *
     * @param \WalletBundle\Entity\UserCredit $credit
     *
     * @return TypeBalance
     */
    public function addCredit(UserCredit $credit)
    {
        $this->credits[] = $credit;

        return $this;
    }

    /**
     * Remove credit
     *
     * @param \WalletBundle\Entity\UserCredit $credit
     */
    public function removeCredit(UserCredit $credit)
    {
        $this->credits->removeElement($credit);
    }

    /**
     * Get credits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Add profit
     *
     * @param \WalletBundle\Entity\UserProfit $profit
     *
     * @return TypeBalance
     */
    public function addProfit(UserProfit $profit)
    {
        $this->profits[] = $profit;

        return $this;
    }

    /**
     * Remove profit
     *
     * @param \WalletBundle\Entity\UserProfit $profit
     */
    public function removeProfit(UserProfit $profit)
    {
        $this->profits->removeElement($profit);
    }

    /**
     * Get profits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfits()
    {
        return $this->profits;
    }
}
