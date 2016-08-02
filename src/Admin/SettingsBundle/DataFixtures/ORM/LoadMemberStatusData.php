<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/20/16
 * Time: 9:58 AM
 */

namespace Admin\SettingsBundle\DataFixtures\ORM;

use Admin\SettingsBundle\Entity\MemberStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMemberStatusData
 * @package Admin\SettingsBundle\DataFixtures\ORM
 */
class LoadMemberStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = new \DateTime();
        $text = '<ul class="list-unstyled text-left"><li><i class="fa fa-times text-danger"></i> 2 years access <strong> to all storage locations</strong></li><li><i class="fa fa-times text-danger"></i> <strong>Unlimited</strong> storage</li><li><i class="fa fa-check text-success"></i> Limited <strong> download quota</strong></li><li><i class="fa fa-check text-success"></i> <strong>Cash on Delivery</strong></li><li><i class="fa fa-check text-success"></i> All time <strong> updates</strong></li><li><i class="fa fa-times text-danger"></i> <strong>Unlimited</strong> access to all files</li><li><i class="fa fa-times text-danger"></i> <strong>Allowed</strong> to be exclusing per sale</li></ul>';

        $status = new MemberStatus();
        $status->setName('Silver');
        $status->setPrice(50);
        $status->setCredits(50);
        $status->setPercent(8);
        $status->setImage('status.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription($text);
        $manager->persist($status);
        $this->addReference('silver', $status);

        $status = new MemberStatus();
        $status->setName('Gold');
        $status->setPrice(199);
        $status->setCredits(200);
        $status->setPercent(10);
        $status->setImage('status.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription($text);
        $manager->persist($status);
        $this->addReference('gold', $status);

        $status = new MemberStatus();
        $status->setName('Diamond');
        $status->setPrice(499);
        $status->setCredits(500);
        $status->setPercent(12);
        $status->setImage('status.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription($text);
        $manager->persist($status);
        $this->addReference('diamond', $status);

        $status = new MemberStatus();
        $status->setName('Ethereum');
        $status->setPrice(999);
        $status->setCredits(1000);
        $status->setPercent(15);
        $status->setImage('status.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription($text);
        $manager->persist($status);
        $this->addReference('ethereum', $status);

        $status = new MemberStatus();
        $status->setName('Ethereum PRO');
        $status->setPrice(1999);
        $status->setCredits(2000);
        $status->setPercent(20);
        $status->setImage('status.jpg');
        $status->setUpdatedAt($data);
        $status->setDescription($text);
        $manager->persist($status);
        $this->addReference('ethereum_pro', $status);

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
