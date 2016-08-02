<?php

namespace Admin\MembersBundle\Controller;

use Admin\MembersBundle\Form\Type\MemberFormType;
use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

/**
 * Class MembersController
 * @package Admin\MembersBundle\Controller
 */
class MembersController extends Controller
{
    /**
     * @return array
     *
     * @Route("/members", name="members_members")
     * @Template("AdminMembersBundle::members.html.twig")
     */
    public function membersAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('members.members'), $this->get("router")->generate('members_members'));

        return array();
    }

    /**
     * @return array
     *
     * @Route("/all-members", name="members_all_members")
     */
    public function allMembersAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('members.members'), $this->get("router")->generate('members_members'));
        $breadcrumbs->addItem($this->get('translator')->trans('members.all_members'));

        $source = new Entity('UserBundle:User');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'usernameCanonical',
            'emailCanonical',
            'salt',
            'password',
            'confirmationToken',
            'passwordRequestedAt',
            'expired',
            'expiresAt',
            'credentialsExpired',
            'credentialsExpireAt',
            'roles',
            'lastLogin',
            'lastIp',
            'skype',
            'phone',
            'registrationFee',
            'debt',
            'verificationStatus',
            'fullName',
            'country',
            'city',
            'address',
        ));

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('registrationFee')->setFilterable(false);
        $grid->getColumn('debt')->setFilterable(false);
        $grid->getColumn('verificationStatus')->setFilterable(false);
        $grid->getColumn('fullName')->setFilterable(false);
        $grid->getColumn('country')->setFilterable(false);
        $grid->getColumn('city')->setFilterable(false);
        $grid->getColumn('address')->setFilterable(false);
        $grid->getColumn('usernameCanonical')->setFilterable(false);
        $grid->getColumn('emailCanonical')->setFilterable(false);
        $grid->getColumn('salt')->setFilterable(false);
        $grid->getColumn('password')->setFilterable(false);
        $grid->getColumn('lastLogin')->setFilterable(false);
        $grid->getColumn('confirmationToken')->setFilterable(false);
        $grid->getColumn('passwordRequestedAt')->setFilterable(false);
        $grid->getColumn('expired')->setFilterable(false);
        $grid->getColumn('expiresAt')->setFilterable(false);
        $grid->getColumn('credentialsExpired')->setFilterable(false);
        $grid->getColumn('credentialsExpireAt')->setFilterable(false);
        $grid->getColumn('registrationDate')->setFilterable(false);
        $grid->getColumn('lastIp')->setFilterable(false);
        $grid->getColumn('referer')->setFilterable(false);
        $grid->getColumn('skype')->setFilterable(false);
        $grid->getColumn('phone')->setFilterable(false);
        $grid->getColumn('roles')->setFilterable(false);

        $translator = $this->get('translator');

        $grid->getColumn('username')->setTitle($translator->trans('members.username'))->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('email')->setTitle('Email')->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('enabled')->setTitle($translator->trans('members.enable'))->setSize(-1)->setOperators(array('eq'))->setDefaultOperator('eq')->setOperatorsVisible(false)->setFilterType('select')->setValues(array(0 => $translator->trans('members.disabled'), 1 => $translator->trans('members.enabled')))->setSelectExpanded(true);
        $grid->getColumn('locked')->setTitle($translator->trans('members.locked'))->setSize(-1)->setOperators(array('eq'))->setDefaultOperator('eq')->setOperatorsVisible(false)->setFilterType('select')->setValues(array(0 => $translator->trans('members.disabled'), 1 => $translator->trans('members.enabled')))->setSelectExpanded(true);
//        $grid->getColumn('roles')->setTitle($translator->trans('members.roles'))->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('registrationIp')->setTitle($translator->trans('members.registrationIp'))->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->getColumn('lastLogin')->setTitle($translator->trans('members.lastLogin'));
        $grid->getColumn('registrationDate')->setTitle($translator->trans('members.registrationDate'));
        $grid->getColumn('lastIp')->setTitle($translator->trans('members.lastIp'));
        $grid->getColumn('referer')->setTitle('Реферер');

        $sponsor    = new TextColumn(array(
            'id'    => 'sponsor',
            'field' => 'sponsor.username',
            'title' => $translator->trans('members.sponsor'),
            'source'    => true,
            'align' => 'center',
        ));
        $sponsor->setOperators(array('like'))->setDefaultOperator('like')->setOperatorsVisible(false);
        $grid->addColumn($sponsor, 5);

        $enableAction = new MassAction($translator->trans('members.enabling'), 'Admin\MembersBundle\Controller\MembersController::enableAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($enableAction);

        $disableAction = new MassAction($translator->trans('members.disable'), 'Admin\MembersBundle\Controller\MembersController::disableAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($disableAction);

        $lockAction = new MassAction($translator->trans('members.lock'), 'Admin\MembersBundle\Controller\MembersController::lockAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($lockAction);

        $unlockAction = new MassAction($translator->trans('members.unlock'), 'Admin\MembersBundle\Controller\MembersController::unlockAction', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($unlockAction);

        $editAction = new RowAction('edit', 'members_edit_member');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

//        $deleteAction = new RowAction('delete', 'members_delete_member', true);
//        $deleteAction->setRouteParameters(array('id'));
//        $deleteAction->setConfirmMessage($translator->trans('members.delete_confirm_message'));
//        $grid->addRowAction($deleteAction);

        $loginAction = new RowAction('login', 'members_member_login', false, '_blank');
        $loginAction->setRouteParameters(array('id'));
        $grid->addRowAction($loginAction);


        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(array(50, 100, 200));

        return $grid->getGridResponse('AdminMembersBundle::all_members.html.twig');
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function enableAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user User */
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setEnabled(true);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function disableAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user User */
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setEnabled(false);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function lockAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user User */
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setLocked(true);
            $em->flush();
        }
    }

    /**
     * @param array  $primaryKeys
     * @param array  $allPrimaryKeys
     * @param string $session
     * @param array  $parameters
     */
    public static function unlockAction($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];
        foreach ($primaryKeys as $id) {
            /* @var $user User */
            $user = $em->getRepository('UserBundle:User')->find($id);
            $user->setLocked(false);
            $em->flush();
        }
    }

    /**
     * Edit member
     *
     * @param Request $request
     * @param integer $id
     * @return array
     *
     * @Route("/edit-member/{id}", name="members_edit_member")
     * @Template("AdminMembersBundle::edit_member.html.twig")
     */
    public function editMemberAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $member = $em->getRepository('UserBundle:User')->find($id);

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('members.members'), $this->get("router")->generate('members_members'));
        $breadcrumbs->addItem($this->get('translator')->trans('members.all_members'), $this->get("router")->generate('members_all_members'));
        $breadcrumbs->addItem($member->getUsername());

        $form   = $this->createForm(new MemberFormType($em), $member);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                /** @var $data User */
                $data   = $form->getData();

                $userManager = $this->get('fos_user.user_manager');
                $userManager->updateUser($data, true);

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('saved')
                );

                return $this->redirectToRoute('members_edit_member', array('id' => $id));
            }
        }

        return array(
            'member'    => $member,
            'form'      => $form->createView(),
        );
    }

    /**
     * @param integer $id
     * @return array
     *
     * @Route("/delete-member/{id}", name="members_delete_member")
     */
    public function deleteMemberAction($id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $member = $em->getRepository('UserBundle:User')->find($id);

        if ($member) {
            $em->remove($member);
            $em->flush();
        }

        return $this->redirectToRoute('members_all_members');
    }

    /**
     * @param Request $request
     * @param integer $id
     * @return array
     *
     * @Route("/member-login/{id}", name="members_member_login")
     */
    public function loginUserAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AdminSettingsBundle:MainSettings')->findOneBy(array());

        return $this->redirect($settings->getHostName().'/abra-ka-da-bra-secret-login-user/'.$id);
    }
}
