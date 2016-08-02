<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/16/16
 * Time: 2:57 PM
 */

namespace Admin\StaticPageBundle\DataFixtures\ORM;

use Admin\StaticPageBundle\Entity\StaticPage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadStaticPageData
 * @package Admin\StaticPageBundle\DataFixtures\ORM
 */
class LoadStaticPageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $text = '';
        $page = new StaticPage();
        $page->setTitle('home');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('about');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('affiliate_program');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('exchange');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('getting_started');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('contact');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('privacy');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('terms_and_conditions');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);

        $text = '';
        $page = new StaticPage();
        $page->setTitle('footer');
        $page->setLocale('en');
        $page->setText($text);
        $manager->persist($page);


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
