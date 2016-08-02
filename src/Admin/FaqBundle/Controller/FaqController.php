<?php

namespace Admin\FaqBundle\Controller;

use Admin\FaqBundle\Entity\Faq;
use Admin\FaqBundle\Form\Type\FaqFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FaqController
 * @package Admin\FaqBundle\Controller
 */
class FaqController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/all-faq/{id}", name="faq_all_faq")
     * @Template("AdminFaqBundle::all_faq.html.twig")
     */
    public function indexAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $faqs = $em->getRepository('AdminFaqBundle:Faq')->findAll();

        $faq = ($id) ? $em->getRepository('AdminFaqBundle:Faq')->find($id) : new Faq();

        $form = $this->createForm(new FaqFormType(), $faq);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirect($this->generateUrl('faq_all_faq'));
            }
        }

        return array(
            'form'  => $form->createView(),
            'faqs'  => $faqs,
        );
    }
}
