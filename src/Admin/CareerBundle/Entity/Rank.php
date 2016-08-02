<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/7/16
 * Time: 10:43 AM
 */

namespace Admin\CareerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Rank
 * @package Admin\CareerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="ranks")
 * @Vich\Uploadable
 */
class Rank
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Vich\UploadableField(mapping="rank_image", fileNameProperty="image")
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $reward;

    /**
     * @ORM\Column(type="integer", name="weak_foot")
     */
    protected $weakFoot;

    /**
     * @ORM\Column(type="integer", name="overall_volume")
     */
    protected $overallVolume;

    /**
     * @ORM\Column(type="integer", name="count_referrals")
     */
    protected $countReferrals;

    /**
     * @ORM\ManyToOne(targetEntity="Admin\CareerBundle\Entity\Rank")
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $rank;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="rank", cascade={"persist", "remove"})
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Admin\CareerBundle\Entity\SuccessRank", mappedBy="rank", cascade={"persist", "remove"})
     */
    protected $history;

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
     * Set image
     *
     * @param string $image
     *
     * @return Rank
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Rank
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
     * Set reward
     *
     * @param string $reward
     *
     * @return Rank
     */
    public function setReward($reward)
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * Get reward
     *
     * @return string
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * Set weakFoot
     *
     * @param integer $weakFoot
     *
     * @return Rank
     */
    public function setWeakFoot($weakFoot)
    {
        $this->weakFoot = $weakFoot;

        return $this;
    }

    /**
     * Get weakFoot
     *
     * @return integer
     */
    public function getWeakFoot()
    {
        return $this->weakFoot;
    }

    /**
     * Set overallVolume
     *
     * @param integer $overallVolume
     *
     * @return Rank
     */
    public function setOverallVolume($overallVolume)
    {
        $this->overallVolume = $overallVolume;

        return $this;
    }

    /**
     * Get overallVolume
     *
     * @return integer
     */
    public function getOverallVolume()
    {
        return $this->overallVolume;
    }

    /**
     * Set countReferrals
     *
     * @param integer $countReferrals
     *
     * @return Rank
     */
    public function setCountReferrals($countReferrals)
    {
        $this->countReferrals = $countReferrals;

        return $this;
    }

    /**
     * Get countReferrals
     *
     * @return integer
     */
    public function getCountReferrals()
    {
        return $this->countReferrals;
    }

    /**
     * Set rank
     *
     * @param \Admin\CareerBundle\Entity\Rank $rank
     *
     * @return Rank
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Rank
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Rank
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserBundle\Entity\User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add history
     *
     * @param \Admin\CareerBundle\Entity\SuccessRank $history
     *
     * @return Rank
     */
    public function addHistory(SuccessRank $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \Admin\CareerBundle\Entity\SuccessRank $history
     */
    public function removeHistory(SuccessRank $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }
}
