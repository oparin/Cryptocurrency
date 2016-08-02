<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 18.03.16
 * Time: 15:33
 */

namespace UserBundle\EventListener;


use Doctrine\ORM\EntityManager;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use UserBundle\Entity\User;

/**
 * Class LoginListener
 * @package UserBundle\EventListener
 */
class LoginListener implements EventSubscriberInterface
{
    private $container;
    private $em;

    /**
     * LoginListener constructor.
     *
     * @param $container
     * @param EntityManager $em
     */
    public function __construct($container, EntityManager $em)
    {

        $this->container    = $container;
        $this->em           = $em;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => 'onLogin',
        );
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onLogin(InteractiveLoginEvent $event)
    {
        $request    = $event->getRequest();

        /** @var $user User */
        $user       = $event->getAuthenticationToken()->getUser();

        if (!in_array('ROLE_ADMIN', $user->getRoles())) {
            $user->setLastIp($request->getClientIp());

            $this->em->flush($user);
        }
    }
}
