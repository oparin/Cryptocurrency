<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.07.2015
 * Time: 14:43
 */

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Verification
 * @package UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user_verification")
 * @Vich\Uploadable
 */
class Verification
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", mappedBy="verification", cascade={"persist", "remove"})
     */
    protected $user;

    /**
     * @Vich\UploadableField(mapping="passport_photo", fileNameProperty="passportPhotoName")
     */
    protected $passportPhotoFile;

    /**
     * @ORM\Column(type="string", length=255, name="passport_photo", nullable=true)
     */
    protected $passportPhotoName;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @param File $image
     */
    public function setPassportPhotoFile(File $image = null)
    {
        $this->passportPhotoFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getPassportPhotoFile()
    {
        return $this->passportPhotoFile;
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
     * Set passportPhotoName
     *
     * @param string $passportPhotoName
     * @return Verification
     */
    public function setPassportPhotoName($passportPhotoName)
    {
        $this->passportPhotoName = $passportPhotoName;

        return $this;
    }

    /**
     * Get passportPhotoName
     *
     * @return string
     */
    public function getPassportPhotoName()
    {
        return $this->passportPhotoName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Verification
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
     * @param User|null $user
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}
