<?php

namespace Admin\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SecurityController
 * @package Admin\UserBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirectToRoute('fos_user_security_login');
    }
}
