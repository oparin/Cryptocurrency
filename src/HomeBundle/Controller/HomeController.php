<?php

namespace HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class HomeController
 * @package HomeBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @return array
     *
     * @Route("/", name="home_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'home',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Route("/about", name="home_about")
     * @Template("HomeBundle::about.html.twig")
     */
    public function aboutAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'about',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Route("/affiliate-program", name="home_affiliate_program")
     * @Template("HomeBundle::affiliate_program.html.twig")
     */
    public function affiliateProgramAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'affiliate_program',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Route("/exchange", name="home_exchange")
     * @Template("HomeBundle::exchange.html.twig")
     */
    public function exchangeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'exchange',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Route("/getting-started", name="home_getting_started")
     * @Template("HomeBundle::getting_started.html.twig")
     */
    public function gettingStartedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'getting_started',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/contacts", name="home_contacts")
     * @Template("HomeBundle:Contacts:contacts.html.twig")
     */
    public function contactsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'contact',
            'locale'    => $request->getLocale(),
        ));

        $form = $this->createFormBuilder()
            ->add('name', 'text', array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'home.contacts.name',
            ))
            ->add('email', 'email', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('message', 'textarea', array(
                'constraints'   => array(new NotBlank()),
                'label'         => 'home.contacts.message',
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $captcha = $_POST['g-recaptcha-response'];
//                $result = file_get_contents('www.google.com/recaptcha/api/siteverify?secret=6LeHkBkTAAAAAC611CPnLQKJyqwDeaJ1hFuEhfl9&response='.$captcha);
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query(array(
//                        'secret'    => '6LeHkBkTAAAAAC611CPnLQKJyqwDeaJ1hFuEhfl9',
                        'secret'    => $this->get('service_container')->getParameter('captcha_secret'),
                        'response'  => $captcha,
                    ))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $result = json_decode($response);
                if ($result->success) {
                    $adminEmail = $this->get('service_container')->getParameter('admin_email');
                    $name = $form->get('name')->getData();
                    $text = $form->get('message')->getData();
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Contacts form')
                        ->setFrom($adminEmail)
                        ->setTo($adminEmail)
                        ->setBody(
                            $this->renderView(
                                'HomeBundle:Contacts:email.html.twig',
                                array(
                                    'name'  => $name,
                                    'email' => $form->get('email')->getData(),
                                    'text'  => $text,
                                )
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);
                    $this->addFlash('success', $this->get('translator')->trans('home.contacts.mesage_sent_succces'));

                    return $this->redirectToRoute('home_contacts');
                } else {
                    $this->addFlash('error', 'Invalid Captcha!');
                }
            }
        }

        return array(
            'form' => $form->createView(),
            'content'  => $page->getText(),
            'site_key' => $this->get('service_container')->getParameter('captcha'),
        );
    }

    /**
     * @return array
     *
     * @Route("/privacy", name="home_privacy")
     * @Template("HomeBundle::privacy.html.twig")
     */
    public function privacyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'privacy',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Route("/terms-and-conditions", name="home_terms_and_conditions")
     * @Template("HomeBundle::terms_and_conditions.html.twig")
     */
    public function termsAndConditionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'terms_and_conditions',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }

    /**
     * @return array
     *
     * @Template("HomeBundle::footer.html.twig")
     */
    public function footerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $page = $em->getRepository('AdminStaticPageBundle:StaticPage')->findOneBy(array(
            'title' => 'footer',
            'locale'    => $request->getLocale(),
        ));

        return array(
            'content'  => $page->getText(),
        );
    }
}
