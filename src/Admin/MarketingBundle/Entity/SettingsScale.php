<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/31/16
 * Time: 4:14 PM
 */

namespace Admin\MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SettingsScale
 * @package Admin\MarketingBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="settings_scale")
 */
class SettingsScale
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $percent;

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
     * Set percent
     *
     * @param string $percent
     *
     * @return SettingsScale
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }
}
