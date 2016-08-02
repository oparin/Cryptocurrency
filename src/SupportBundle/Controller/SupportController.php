<?php

namespace SupportBundle\Controller;

use Doctrine\ORM\EntityManager;
use SupportBundle\Entity\ReplySupportTicket;
use SupportBundle\Entity\SupportTicket;
use SupportBundle\Form\Type\SupportTicketFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;

/**
 * Class SupportController
 * @package SupportBundle\Controller
 */
class SupportController extends Controller
{
    /**
     * @return array
     *
     * @Route("/all-tickets", name="all_tickets")
     * @Template("SupportBundle::all_tickets.html.twig")
     */
    public function allTicketsAction()
    {
        /** @var $user User */
        $user = $this->getUser();

        return array(
            'tickets'   => $user->getSupportTickets(),
        );
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/new_ticket", name="new_ticket")
     * @Template("SupportBundle::new_ticket.html.twig")
     */
    public function newTicketAction(Request $request)
    {
        $form = $this->createForm(new SupportTicketFormType());

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var $ticket SupportTicket */
                $ticket = $form->getData();
                $ticket->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($ticket);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Ticket submitted')
                    ->setFrom($this->get('service_container')->getParameter('admin_email'), 'Quantosolution support')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/new_ticket.html.twig',
                            array(
                                'user' => $ticket->getUser()->getUsername(),
                                'subject'    => $ticket->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->addFlash('success', $this->get('translator')->trans('support.ticket_sent_success'));

                return $this->redirectToRoute('new_ticket');
            } else {
                $this->addFlash('error', $this->get('translator')->trans('support.ticket_sent_error'));
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return array
     *
     * @Route("/show-ticket/{id}", name="show_ticket")
     * @Template("SupportBundle::show_ticket.html.twig")
     */
    public function showTicketAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('SupportBundle:SupportTicket')->find($id);

        if (!$ticket || $ticket->getUser() != $this->getUser()) {
            throw new NotFoundHttpException();
        }

        $reply = new ReplySupportTicket();
        $reply->setTicket($ticket);
        $reply->setRole(false);

        $form = $this->createFormBuilder($reply)
            ->add('text', 'textarea', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $ticket->setStatus(0);
                $data = $form->getData();
                $em->persist($data);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Reply noted')
                    ->setFrom($this->get('service_container')->getParameter('admin_email'), 'Quantosolution support')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/reply_ticket.html.twig',
                            array(
                                'user' => $ticket->getUser()->getUsername(),
                                'subject'    => $ticket->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->addFlash('success', $this->get('translator')->trans('support.mesage_sent_succces'));

                return $this->redirectToRoute('show_ticket', array('id' => $id));
            }
        }

        return array(
            'ticket'    => $ticket,
            'form'      => $form->createView(),
            'answers'   => $ticket->getAnswers(),
        );
    }
}
