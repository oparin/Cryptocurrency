<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/7/16
 * Time: 11:12 AM
 */
namespace Admin\CareerBundle\DataFixtures\ORM;

use Admin\CareerBundle\Entity\Rank;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCareerData
 * @package Admin\CareerBundle\DataFixtures\ORM
 */
class LoadCareerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $rank = new Rank();
        $rank->setImage('sapphire.png');
        $rank->setName('Sapphire');
        $rank->setReward('test');
        $rank->setWeakFoot(0);
        $rank->setOverallVolume(7000);
        $rank->setCountReferrals(2);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('sapphire', $rank);

        $rank = new Rank();
        $rank->setName('Ruby');
        $rank->setImage('ruby.png');
        $rank->setReward('test');
        $rank->setWeakFoot(10000);
        $rank->setOverallVolume(40000);
        $rank->setRank($this->getReference('sapphire'));
        $rank->setCountReferrals(2);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('ruby', $rank);

        $rank = new Rank();
        $rank->setName('Emerald');
        $rank->setImage('emerald.png');
        $rank->setReward('test');
        $rank->setWeakFoot(40000);
        $rank->setOverallVolume(80000);
        $rank->setRank($this->getReference('ruby'));
        $rank->setCountReferrals(3);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('emerald', $rank);

        $rank = new Rank();
        $rank->setName('Diamond');
        $rank->setImage('diamond.png');
        $rank->setReward('test');
        $rank->setWeakFoot(80000);
        $rank->setOverallVolume(200000);
        $rank->setRank($this->getReference('emerald'));
        $rank->setCountReferrals(3);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('diamond_rank', $rank);

        $rank = new Rank();
        $rank->setName('Blue Diamond');
        $rank->setImage('blue_diamond.png');
        $rank->setReward('test');
        $rank->setWeakFoot(200000);
        $rank->setOverallVolume(500000);
        $rank->setRank($this->getReference('diamond_rank'));
        $rank->setCountReferrals(4);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('blue_diamond', $rank);

        $rank = new Rank();
        $rank->setName('Black Diamond');
        $rank->setImage('black_diamond.png');
        $rank->setReward('test');
        $rank->setWeakFoot(500000);
        $rank->setOverallVolume(1500000);
        $rank->setRank($this->getReference('blue_diamond'));
        $rank->setCountReferrals(5);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('black_diamond', $rank);

        $rank = new Rank();
        $rank->setName('Crown Diamond');
        $rank->setImage('crown_diamond.png');
        $rank->setReward('test');
        $rank->setWeakFoot(1500000);
        $rank->setOverallVolume(8000000);
        $rank->setRank($this->getReference('black_diamond'));
        $rank->setCountReferrals(6);
        $rank->setUpdatedAt(new \DateTime());
        $manager->persist($rank);
        $this->setReference('crown_diamond', $rank);

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
