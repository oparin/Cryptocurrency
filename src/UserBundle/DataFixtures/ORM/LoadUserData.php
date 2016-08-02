<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11.01.16
 * Time: 18:56
 */

namespace UserBundle\DataFixtures\ORM;

use CareerBundle\Entity\UserCareer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MarketingBundle\Entity\Binary;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCredit;
use WalletBundle\Entity\UserProfit;
use WalletBundle\Entity\UserWallet;

/**
 * Class LoadUserData
 * @package UserBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 2; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setPlainPassword('user'.$i);
            $user->setEmail('user'.$i.'@user.com');
            $user->setEnabled(true);
            $user->addRole('ROLE_USER');
            $manager->persist($user);

            $wallet = new UserWallet();
            $wallet->setUser($user);
            $wallet->setType($this->getReference('type_m'));
            $wallet->setSum(100);
            $manager->persist($wallet);

//            $wallet = new UserWallet();
//            $wallet->setUser($user);
//            $wallet->setType($this->getReference('type_b'));
//            $wallet->setSum(99);
//            $manager->persist($wallet);

            $account = new UserAccount();
            $account->setUser($user);
            $account->setType($this->getReference('type_m'));
            $account->setSum(1000);
            $manager->persist($account);

//            $account = new UserAccount();
//            $account->setUser($user);
//            $account->setType($this->getReference('type_b'));
//            $account->setSum(999);
//            $manager->persist($account);

            $credit = new UserCredit();
            $credit->setUser($user);
            $credit->setType($this->getReference('type_m'));
            $manager->persist($credit);

            $profit = new UserProfit();
            $profit->setUser($user);
            $profit->setType($this->getReference('type_m'));
            $manager->persist($profit);

            $binary = new Binary();
            $binary->setUser($user);
            $manager->persist($binary);

            $career = new UserCareer();
            $career->setUser($user);
            $manager->persist($career);
        }

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
