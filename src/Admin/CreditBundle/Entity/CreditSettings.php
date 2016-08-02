<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/2/16
 * Time: 4:15 PM
 */

namespace Admin\CreditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CreditSettings
 * @package Admin\CreditBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="credits_settings")
 */
class CreditSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $rate;

    /**
     * @ORM\Column(type="decimal", scale=2, name="percent_convert")
     */
    protected $percentConvert;

    /**
     * @ORM\Column(type="integer", name="period_convert")
     */
    protected $periodConvert;

    /**
     * @ORM\Column(type="decimal", scale=2, name="percent_profit")
     */
    protected $percentProfit;

    /**
     * @ORM\Column(type="decimal", scale=2, name="percent_withdraw")
     */
    protected $percentWithdraw;

    /**
     * @ORM\Column(type="integer", name="period_withdraw")
     */
    protected $periodWithdraw;

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
     * Set rate
     *
     * @param string $rate
     *
     * @return CreditSettings
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

    /**
     * Set percentConvert
     *
     * @param string $percentConvert
     *
     * @return CreditSettings
     */
    public function setPercentConvert($percentConvert)
    {
        $this->percentConvert = $percentConvert;

        return $this;
    }

    /**
     * Get percentConvert
     *
     * @return string
     */
    public function getPercentConvert()
    {
        return $this->percentConvert;
    }

    /**
     * Set periodConvert
     *
     * @param integer $periodConvert
     *
     * @return CreditSettings
     */
    public function setPeriodConvert($periodConvert)
    {
        $this->periodConvert = $periodConvert;

        return $this;
    }

    /**
     * Get periodConvert
     *
     * @return integer
     */
    public function getPeriodConvert()
    {
        return $this->periodConvert;
    }

    /**
     * Set percentProfit
     *
     * @param string $percentProfit
     *
     * @return CreditSettings
     */
    public function setPercentProfit($percentProfit)
    {
        $this->percentProfit = $percentProfit;

        return $this;
    }

    /**
     * Get percentProfit
     *
     * @return string
     */
    public function getPercentProfit()
    {
        return $this->percentProfit;
    }

    /**
     * Set percentWithdraw
     *
     * @param string $percentWithdraw
     *
     * @return CreditSettings
     */
    public function setPercentWithdraw($percentWithdraw)
    {
        $this->percentWithdraw = $percentWithdraw;

        return $this;
    }

    /**
     * Get percentWithdraw
     *
     * @return string
     */
    public function getPercentWithdraw()
    {
        return $this->percentWithdraw;
    }

    /**
     * Set periodWithdraw
     *
     * @param integer $periodWithdraw
     *
     * @return CreditSettings
     */
    public function setPeriodWithdraw($periodWithdraw)
    {
        $this->periodWithdraw = $periodWithdraw;

        return $this;
    }

    /**
     * Get periodWithdraw
     *
     * @return integer
     */
    public function getPeriodWithdraw()
    {
        return $this->periodWithdraw;
    }
}
