<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/9/16
 * Time: 3:41 PM
 */

namespace Admin\FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Faq
 * @package Admin\FaqBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="faq")
 */
class Faq
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $locale;

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
     * Set text
     *
     * @param string $text
     *
     * @return Faq
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
     * Set locale
     *
     * @param string $locale
     *
     * @return Faq
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
