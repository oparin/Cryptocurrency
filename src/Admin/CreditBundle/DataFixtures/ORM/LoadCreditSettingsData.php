<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/2/16
 * Time: 4:31 PM
 */

namespace Admin\CreditBundle\DataFixtures\ORM;

use Admin\CreditBundle\Entity\CreditSettings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCreditSettingsData
 * @package Admin\CreditBundle\DataFixtures
 */
class LoadCreditSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $settings = new CreditSettings();
        $settings->setRate(2);
        $settings->setPercentConvert(10);
        $settings->setPeriodConvert(7);
        $settings->setPercentProfit(10);
        $settings->setPercentWithdraw(10);
        $settings->setPeriodWithdraw(7);
        $manager->persist($settings);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
