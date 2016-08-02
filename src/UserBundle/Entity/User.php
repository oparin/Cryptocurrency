<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/12/15
 * Time: 3:31 PM
 */

namespace UserBundle\Entity;

use Admin\CareerBundle\Entity\Rank;
use Admin\CareerBundle\Entity\SuccessRank;
use Admin\SettingsBundle\Entity\MemberStatus;
use CareerBundle\Entity\UserCareer;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Binary;
use StatisticBundle\Entity\PointsStatistic;
use StatisticBundle\Entity\ScaleBonusStatistic;
use StatisticBundle\Entity\SponsorBonusStatistic;
use StatisticBundle\Entity\TransactionStatistic;
use SupportBundle\Entity\SupportTicket;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCredit;
use WalletBundle\Entity\UserProfit;
use WalletBundle\Entity\UserWallet;

/**
 * Class User
 * @package UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $sponsor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $referer;

    /**
     * @ORM\Column(type="datetime", name="registration_date", nullable=true)
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="string", name="registration_ip", nullable=true)
     */
    protected $registrationIp;

    /**
     * @ORM\Column(type="string", name="last_ip", nullable=true)
     */
    protected $lastIp;

    /**
     * @ORM\OneToMany(targetEntity="SupportBundle\Entity\SupportTicket", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $supportTickets;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $skype;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserAccount", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $accounts;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserWallet", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $wallets;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserCredit", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $credits;

    /**
     * @ORM\OneToMany(targetEntity="WalletBundle\Entity\UserProfit", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $profits;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\SettingsBundle\Entity\MemberStatus", inversedBy="users")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $status;

    /**
     * @ORM\Column(type="boolean", name="registration_fee")
     */
    protected $registrationFee = false;

    /**
     * @ORM\OneToOne(targetEntity="MarketingBundle\Entity\Binary", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $binary;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="father_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $father;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\SponsorBonusStatistic", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $sponsorBonus;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\ScaleBonusStatistic", mappedBy="userTo", cascade={"persist", "remove"})
     */
    protected $scaleMyBonus;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\TransactionStatistic", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $transactionStatistic;

    /**
     * @ORM\OneToMany(targetEntity="StatisticBundle\Entity\PointsStatistic", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $statisticPoints;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $debt = 0.00;

    /**
     * @ORM\OneToOne(targetEntity="CareerBundle\Entity\UserCareer", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $career;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CareerBundle\Entity\Rank", inversedBy="users")
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rank;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\Verification", inversedBy="user")
     * @ORM\JoinColumn(name="verification_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $verification;

    /**
     * 0 - none
     * 1 - wait
     * 2 - done
     * 3 - cancel
     *
     * @ORM\Column(type="smallint", name="verification_status")
     */
    protected $verificationStatus = 0;

    /**
     * @ORM\Column(type="text", name="full_name", nullable=true)
     */
    protected $fullName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\OneToMany(targetEntity="Admin\CareerBundle\Entity\SuccessRank", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $ranks;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set registrationIp
     *
     * @param string $registrationIp
     *
     * @return User
     */
    public function setRegistrationIp($registrationIp)
    {
        $this->registrationIp = $registrationIp;

        return $this;
    }

    /**
     * Get registrationIp
     *
     * @return string
     */
    public function getRegistrationIp()
    {
        return $this->registrationIp;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     *
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set sponsor
     *
     * @param \UserBundle\Entity\User $sponsor
     *
     * @return User
     */
    public function setSponsor(User $sponsor = null)
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * Get sponsor
     *
     * @return \UserBundle\Entity\User
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * Add supportTicket
     *
     * @param \SupportBundle\Entity\SupportTicket $supportTicket
     *
     * @return User
     */
    public function addSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets[] = $supportTicket;

        return $this;
    }

    /**
     * Remove supportTicket
     *
     * @param \SupportBundle\Entity\SupportTicket $supportTicket
     */
    public function removeSupportTicket(SupportTicket $supportTicket)
    {
        $this->supportTickets->removeElement($supportTicket);
    }

    /**
     * Get supportTickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSupportTickets()
    {
        return $this->supportTickets;
    }

    /**
     * Set referer
     *
     * @param string $referer
     *
     * @return User
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set skype
     *
     * @param string $skype
     *
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add account
     *
     * @param \WalletBundle\Entity\UserAccount $account
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * Set status
     *
     * @param \Admin\SettingsBundle\Entity\MemberStatus $status
     *
     * @return User
     */
    public function setStatus(MemberStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Admin\SettingsBundle\Entity\MemberStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set registrationFee
     *
     * @param boolean $registrationFee
     *
     * @return User
     */
    public function setRegistrationFee($registrationFee)
    {
        $this->registrationFee = $registrationFee;

        return $this;
    }

    /**
     * Get registrationFee
     *
     * @return boolean
     */
    public function getRegistrationFee()
    {
        return $this->registrationFee;
    }

    /**
     * Set binary
     *
     * @param \MarketingBundle\Entity\Binary $binary
     *
     * @return User
     */
    public function setBinary(Binary $binary = null)
    {
        $this->binary = $binary;

        return $this;
    }

    /**
     * Get binary
     *
     * @return \MarketingBundle\Entity\Binary
     */
    public function getBinary()
    {
        return $this->binary;
    }

    /**
     * Set father
     *
     * @param \UserBundle\Entity\User $father
     *
     * @return User
     */
    public function setFather(User $father = null)
    {
        $this->father = $father;

        return $this;
    }

    /**
     * Get father
     *
     * @return \UserBundle\Entity\User
     */
    public function getFather()
    {
        return $this->father;
    }

    /**
     * Add sponsorBonus
     *
     * @param \StatisticBundle\Entity\SponsorBonusStatistic $sponsorBonus
     *
     * @return User
     */
    public function addSponsorBonus(SponsorBonusStatistic $sponsorBonus)
    {
        $this->sponsorBonus[] = $sponsorBonus;

        return $this;
    }

    /**
     * Remove sponsorBonus
     *
     * @param \StatisticBundle\Entity\SponsorBonusStatistic $sponsorBonus
     */
    public function removeSponsorBonus(SponsorBonusStatistic $sponsorBonus)
    {
        $this->sponsorBonus->removeElement($sponsorBonus);
    }

    /**
     * Get sponsorBonus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSponsorBonus()
    {
        return $this->sponsorBonus;
    }

    /**
     * Add transactionStatistic
     *
     * @param \StatisticBundle\Entity\TransactionStatistic $transactionStatistic
     *
     * @return User
     */
    public function addTransactionStatistic(TransactionStatistic $transactionStatistic)
    {
        $this->transactionStatistic[] = $transactionStatistic;

        return $this;
    }

    /**
     * Remove transactionStatistic
     *
     * @param \StatisticBundle\Entity\TransactionStatistic $transactionStatistic
     */
    public function removeTransactionStatistic(TransactionStatistic $transactionStatistic)
    {
        $this->transactionStatistic->removeElement($transactionStatistic);
    }

    /**
     * Get transactionStatistic
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactionStatistic()
    {
        return $this->transactionStatistic;
    }

    /**
     * Add statisticPoint
     *
     * @param \StatisticBundle\Entity\PointsStatistic $statisticPoint
     *
     * @return User
     */
    public function addStatisticPoint(PointsStatistic $statisticPoint)
    {
        $this->statisticPoints[] = $statisticPoint;

        return $this;
    }

    /**
     * Remove statisticPoint
     *
     * @param \StatisticBundle\Entity\PointsStatistic $statisticPoint
     */
    public function removeStatisticPoint(PointsStatistic $statisticPoint)
    {
        $this->statisticPoints->removeElement($statisticPoint);
    }

    /**
     * Get statisticPoints
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStatisticPoints()
    {
        return $this->statisticPoints;
    }

    /**
     * Add profit
     *
     * @param \WalletBundle\Entity\UserProfit $profit
     *
     * @return User
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

    /**
     * Set debt
     *
     * @param string $debt
     *
     * @return User
     */
    public function setDebt($debt)
    {
        $this->debt = $debt;

        return $this;
    }

    /**
     * Get debt
     *
     * @return string
     */
    public function getDebt()
    {
        return $this->debt;
    }

    /**
     * Set career
     *
     * @param \CareerBundle\Entity\UserCareer $career
     *
     * @return User
     */
    public function setCareer(UserCareer $career = null)
    {
        $this->career = $career;

        return $this;
    }

    /**
     * Get career
     *
     * @return \CareerBundle\Entity\UserCareer
     */
    public function getCareer()
    {
        return $this->career;
    }

    /**
     * Set rank
     *
     * @param \Admin\CareerBundle\Entity\Rank $rank
     *
     * @return User
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
     * Set verification
     *
     * @param \UserBundle\Entity\Verification $verification
     *
     * @return User
     */
    public function setVerification(Verification $verification = null)
    {
        $this->verification = $verification;

        return $this;
    }

    /**
     * Get verification
     *
     * @return \UserBundle\Entity\Verification
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * Set verificationStatus
     *
     * @param integer $verificationStatus
     *
     * @return User
     */
    public function setVerificationStatus($verificationStatus)
    {
        $this->verificationStatus = $verificationStatus;

        return $this;
    }

    /**
     * Get verificationStatus
     *
     * @return integer
     */
    public function getVerificationStatus()
    {
        return $this->verificationStatus;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add scaleMyBonus
     *
     * @param \StatisticBundle\Entity\ScaleBonusStatistic $scaleMyBonus
     *
     * @return User
     */
    public function addScaleMyBonus(ScaleBonusStatistic $scaleMyBonus)
    {
        $this->scaleMyBonus[] = $scaleMyBonus;

        return $this;
    }

    /**
     * Remove scaleMyBonus
     *
     * @param \StatisticBundle\Entity\ScaleBonusStatistic $scaleMyBonus
     */
    public function removeScaleMyBonus(ScaleBonusStatistic $scaleMyBonus)
    {
        $this->scaleMyBonus->removeElement($scaleMyBonus);
    }

    /**
     * Get scaleMyBonus
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScaleMyBonus()
    {
        return $this->scaleMyBonus;
    }

    /**
     * Add rank
     *
     * @param \Admin\CareerBundle\Entity\SuccessRank $rank
     *
     * @return User
     */
    public function addRank(SuccessRank $rank)
    {
        $this->ranks[] = $rank;

        return $this;
    }

    /**
     * Remove rank
     *
     * @param \Admin\CareerBundle\Entity\SuccessRank $rank
     */
    public function removeRank(SuccessRank $rank)
    {
        $this->ranks->removeElement($rank);
    }

    /**
     * Get ranks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRanks()
    {
        return $this->ranks;
    }
}
