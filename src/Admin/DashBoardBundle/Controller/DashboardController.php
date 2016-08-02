<?php

namespace Admin\DashBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DashboardController
 * @package Admin\DashBoardBundle\Controller
 */
class DashboardController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'test');
    }
}
