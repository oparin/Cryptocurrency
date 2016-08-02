<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/12/15
 * Time: 3:57 PM
 */

namespace UserBundle\EventListener;

use CareerBundle\Entity\UserCareer;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use UserBundle\Entity\User;
use WalletBundle\Entity\UserAccount;
use WalletBundle\Entity\UserCredit;
use WalletBundle\Entity\UserProfit;
use WalletBundle\Entity\UserWallet;

/**
 * Class RegistrationSuccessListener
 */
class RegistrationSuccessListener implements EventSubscriberInterface
{
    private $em;
    private $session;

    /**
     * RegistrationSuccessListener constructor.
     * @param EntityManager $em
     * @param Session       $session
     */
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em       = $em;
        $this->session  = $session;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
        );
    }

    /**
     * @param FilterUserResponseEvent $event
     */
    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $request    = $event->getRequest();

        /** @var $user User */
        $user       = $event->getUser();

        $user->setRegistrationDate(new \DateTime());
        $user->setRegistrationIp($request->getClientIp());
        $user->setReferer($this->session->get('referer'));
        $sponsorName = $this->session->get('referral');
        $sponsor = $this->em->getRepository('UserBundle:User')->findOneBy(array(
            'username' => $sponsorName,
        ));
        if ($sponsor) {
            $user->setSponsor($sponsor);
        }

        $typeBalance = $this->em->getRepository('WalletBundle:TypeBalance')->findAll();
        // Set Wallets
        foreach ($typeBalance as $type) {
            $wallet = new UserWallet();
            $wallet->setUser($user);
            $wallet->setType($type);
            $this->em->persist($wallet);

            $account = new UserAccount();
            $account->setUser($user);
            $account->setType($type);
            $this->em->persist($account);

            $credit = new UserCredit();
            $credit->setUser($user);
            $credit->setType($type);
            $this->em->persist($credit);

            $profit = new UserProfit();
            $profit->setUser($user);
            $profit->setType($type);
            $this->em->persist($profit);
        }

        $career = new UserCareer();
        $career->setUser($user);
        $this->em->persist($career);

        $this->em->flush($user);
    }
}
