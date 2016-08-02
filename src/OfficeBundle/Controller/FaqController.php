<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/9/16
 * Time: 4:22 PM
 */

namespace OfficeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class FaqController
 * @package OfficeBundle\Controller
 */
class FaqController extends Controller
{
    /**
     * @return array
     *
     * @Route("/faq", name="office_faq")
     * @Template("OfficeBundle:Faq:faq.html.twig")
     */
    public function faqAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $request = $this->get('request');
        $faq = $em->getRepository('AdminFaqBundle:Faq')->findOneBy(array(
            'locale'    => $request->getLocale(),
        ));

        return array(
            'faq'   => $faq,
        );
    }
}
