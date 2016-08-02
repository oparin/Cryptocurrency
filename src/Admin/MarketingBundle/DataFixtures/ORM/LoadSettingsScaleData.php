<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/31/16
 * Time: 5:20 PM
 */

namespace Admin\MarketingBundle\DataFixtures\ORM;

use Admin\MarketingBundle\Entity\SettingsScale;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadSettingsScaleData
 * @package Admin\MarketingBundle\DataFixtures\ORM
 */
class LoadSettingsScaleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $settings = new SettingsScale();
        $settings->setPercent(10);
        $manager->persist($settings);

        $settings = new SettingsScale();
        $settings->setPercent(5);
        $manager->persist($settings);

        $settings = new SettingsScale();
        $settings->setPercent(2);
        $manager->persist($settings);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
