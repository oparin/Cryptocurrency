<?php

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\MainSettingsFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MainSettingsController
 * @package Admin\SettingsBundle\Controller
 */
class MainSettingsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/main-settings", name="settings_main_settings")
     * @Template("AdminSettingsBundle:MainSettings:main_settings.html.twig")
     */
    public function indexAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('settings.main_settings.main_settings'), $this->get("router")->generate('settings_main_settings'));

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

        $form = $this->createForm(new MainSettingsFormType(), $settings);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->flush($data);

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('saved')
                );

                return $this->redirectToRoute('settings_main_settings');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
