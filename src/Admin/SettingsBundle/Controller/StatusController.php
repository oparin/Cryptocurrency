<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/30/15
 * Time: 5:17 PM
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\MemberStatusFormType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StatusController
 * @package Admin\SettingsBundle\Controller
 */
class StatusController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/member-status-settings/{id}", name="settings_members_status_settings")
     * @Template("AdminSettingsBundle:Status:status_settings.html.twig")
     */
    public function generalSettingsAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        if (!$id) {
            $status = null;
        } else {
            $status = $em->getRepository('AdminSettingsBundle:MemberStatus')->find($id);
        }

        $form = $this->createForm(new MemberStatusFormType(), $status);

//        $statuses = $em->getRepository('AdminSettingsBundle:MemberStatus')->findBy(array(), array('id' => 'ASC'));

        $source = new Entity('AdminSettingsBundle:MemberStatus');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'image',
            'updatedAt',
            'description',
        ));

        $translator = $this->get('translator');

        $grid->getColumn('name')->setTitle('Имя статуса')->setSize(200);
        $grid->getColumn('price')->setTitle('Цена')->setSize(150);
        $grid->getColumn('percent')->setTitle('Процент от баллов (%)')->setSize(150);
        $grid->getColumn('credits')->setTitle('Юниты')->setSize(150);

        $editAction = new RowAction('edit', 'settings_members_status_settings');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

        $deleteAction = new RowAction('delete', 'settings_members_status_delete', true);
        $deleteAction->setRouteParameters(array('id'));
        $deleteAction->setConfirmMessage($translator->trans('members.delete_confirm_message'));
        $grid->addRowAction($deleteAction);

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush($data);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirectToRoute('settings_members_status_settings');
            }
        }

        return array(
            'form'      => $form->createView(),
//            'statuses'  => $statuses,
            'status'    => $status,
            'grid'      => $grid,
        );
    }

    /**
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/member-status-delete/{id}", name="settings_members_status_delete")
     */
    public function memberStatusDeleteAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('AdminSettingsBundle:MemberStatus')->find($id);
        $em->remove($status);
        $em->flush($status);

        $this->get('session')->getFlashBag()->add(
            'success',
            'Success!'
        );

        return $this->redirectToRoute('settings_members_status_settings');
    }
}
