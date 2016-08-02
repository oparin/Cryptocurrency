<?php

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserController extends Controller
{
    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/abra-ka-da-bra-secret-login-user/{id}")
     */
    public function secretLoginAction($id)
    {
        /* @var $em EntityManager  */
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        if (!$user) {
            throw new UsernameNotFoundException("User not found");
        } else {
            $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
            $this->get("security.token_storage")->setToken($token); //now the user is logged in

        }

        return $this->redirectToRoute('office_dashboard');
    }
}
