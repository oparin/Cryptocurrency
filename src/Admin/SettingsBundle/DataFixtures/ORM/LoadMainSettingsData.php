<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 10:16
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\MainSettings;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMainSettingsData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadMainSettingsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $settings = new MainSettings();
        $settings->setHostName('bookmaker.local');
        $settings->setRegistrationFee(25);
        $settings->setMinWithdraw(50);
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
