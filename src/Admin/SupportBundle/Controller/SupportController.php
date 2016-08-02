<?php

namespace Admin\SupportBundle\Controller;

use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use SupportBundle\Entity\ReplySupportTicket;
use SupportBundle\Entity\SupportTicket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SupportController
 * @package Admin\SupportBundle\Controller
 */
class SupportController extends Controller
{
    /**
     * @return array
     *
     * @Route("/all-support-tickets", name="all_support_tickets")
     * @Template("AdminSupportBundle::all_support_tickets.html.twig")
     */
    public function allSupportTicketsAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('support.all_tickets'));

        $source = new Entity('SupportBundle:SupportTicket');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'text',
        ));

        $translator = $this->get('translator');
        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('text')->setFilterable(false);
        $grid->getColumn('date')->setTitle($translator->trans('date'))->setSize(200)->setFilterable(false);
        $grid->getColumn('subject')->setTitle($translator->trans('support.subject'))->setSize(600)->setFilterable(false);
        $grid->getColumn('status')->setTitle($translator->trans('status'))->setSize(60)
            ->setFilterType('select')
            ->setOperators(array('eq'))
            ->setDefaultOperator('eq')
            ->setOperatorsVisible(false)
            ->setSelectFrom('values')
            ->setValues(array
                (
                    0 => $translator->trans('support.open'),
                    1 => $translator->trans('support.answered'),
                    2 => $translator->trans('support.close'),
                )
            )->setSelectExpanded(true);

        $membership = new TextColumn(
            array(
                'id'        => 'user',
                'field'     => 'user.username',
                'title'     => $translator->trans('support.user'),
                'source'    => true,
                'size'      => 100,
            )
        );
        $membership
            ->setOperators(array('like'))
            ->setDefaultOperator('like')
            ->setOperatorsVisible(false);
        $grid->addColumn($membership, 1);

        $editAction = new RowAction('show', 'support_reply_ticket');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

        $openAction = new MassAction($translator->trans('support.open'), 'Admin\SupportBundle\Controller\SupportController::openAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($openAction);

        $answeredAction = new MassAction($translator->trans('support.answered'), 'Admin\SupportBundle\Controller\SupportController::answeredAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($answeredAction);

        $closeAction = new MassAction($translator->trans('support.close'), 'Admin\SupportBundle\Controller\SupportController::closeAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($closeAction);

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(array(50, 100, 200));

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function openAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $ticket SupportTicket */
            $ticket = $em->getRepository('SupportBundle:SupportTicket')->find($id);
            $ticket->setStatus(0);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function answeredAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $ticket SupportTicket */
            $ticket = $em->getRepository('SupportBundle:SupportTicket')->find($id);
            $ticket->setStatus(1);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function closeAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $ticket SupportTicket */
            $ticket = $em->getRepository('SupportBundle:SupportTicket')->find($id);
            $ticket->setStatus(2);
            $em->flush();
        }
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return array
     *
     * @Route("/show-ticket/{id}", name="support_reply_ticket")
     * @Template("AdminSupportBundle::reply_ticket.html.twig")
     */
    public function replyTicketAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('SupportBundle:SupportTicket')->find($id);

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('support.all_tickets'), $this->get("router")->generate('all_support_tickets'));
        $breadcrumbs->addItem($ticket->getSubject());

        $reply = new ReplySupportTicket();
        $reply->setTicket($ticket);
        $reply->setRole(true);

        $form = $this->createFormBuilder($reply)
            ->add('text', 'textarea', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('close', 'checkbox', array(
                'required'  => false,
                'mapped'    => false,
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($form->get('close')->getData()) {
                    $ticket->setStatus(2);
                } else {
                    $ticket->setStatus(1);
                }
                $data = $form->getData();
                $em->persist($data);
                $em->flush();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Support team replied')
                    ->setFrom($this->get('service_container')->getParameter('admin_email'), 'Quantosolution support')
                    ->setTo($ticket->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'Emails/admin_ticket.html.twig',
                            array(
                                'user' => $ticket->getUser()->getUsername(),
                                'subject'    => $ticket->getSubject(),
                            )
                        ),
                        'text/html'
                    );

                $this->get('mailer')->send($message);

                $this->addFlash('success', $this->get('translator')->trans('sent_succces'));

                return $this->redirectToRoute('support_reply_ticket', array('id' => $id));
            }
        }

        return array(
            'ticket'    => $ticket,
            'form'      => $form->createView(),
            'answers'   => $ticket->getAnswers(),
        );
    }
}
