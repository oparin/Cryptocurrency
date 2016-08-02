<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/11/15
 * Time: 5:12 PM
 */

namespace Admin\UserBundle\DataFixtures\ORM;

use Admin\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 * @package Admin\UserBundle\DataFixtures
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setEnabled(true);
        $admin->addRole('ROLE_ADMIN');
        $manager->persist($admin);

        $manager->flush();

        $this->addReference('admin', $admin);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
