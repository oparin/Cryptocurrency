<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/8/16
 * Time: 12:37 PM
 */

namespace Admin\MembersBundle\Controller;

use Admin\MembersBundle\Grid\Column\DownloadLinkColumn;
use Admin\MembersBundle\Grid\Column\VerificationStatusColumn;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UserBundle\Entity\Verification;

/**
 * Class VerificationController
 * @package Admin\MembersBundle\Controller
 */
class VerificationController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/verification", name="members_verification")
     * @Template("AdminMembersBundle::verification.html.twig")
     */
    public function verificationActions()
    {
        $source = new Entity('UserBundle:Verification');
        $grid = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->leftJoin($tableAlias.'.user', 'u')
                    ->andWhere('u.verificationStatus <> 0');
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'passportPhotoName',
        ));

        $grid->getColumn('id')->setFilterable(false);
        $grid->getColumn('passportPhotoName')->setFilterable(false);
        $grid->getColumn('updatedAt')->setFilterable(false)->setTitle('Date');

        $user = new TextColumn(array(
            'id'    => 'user',
            'field' => 'user.username',
            'title' => 'Member',
            'source' => 'true',
        ));
        $user
            ->setAlign('center')
            ->setOperators(array('like'))
            ->setDefaultOperator('like')
            ->setOperatorsVisible(false);
        $grid->addColumn($user, 1);

        $passportPhoto = new DownloadLinkColumn(array(
            'id'    => 'passportPhoto',
            'title' => 'Passport photo',
        ));
        $passportPhoto->manipulateRenderCell(
            function($value, $row, $router) {
                /* @var $row Row */
                $result = 'uploads/verification/'.$row->getField('passportPhotoName');

                return $result;
            }
        )->setAlign('center');
        $grid->addColumn($passportPhoto, 2);

        $status = new VerificationStatusColumn(array(
            'id'    => 'verStatus',
            'field' => 'user.verificationStatus',
            'title' => 'Status',
            'source'    => 'true',
            'sortable' => true
        ));
        $status
            ->setAlign('center')
            ->setFilterType('select')
            ->setOperators(array('eq'))
            ->setDefaultOperator('eq')
            ->setOperatorsVisible(false)
            ->setSelectFrom('values')
            ->setValues(array(1 => 'Wait', 2 => 'Done', 3 => 'Cancel'));
        $grid->addColumn($status);

        $doneAction = new MassAction('Wait', 'Admin\MembersBundle\Controller\VerificationController::setWait', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($doneAction);

        $doneAction = new MassAction('Done', 'Admin\MembersBundle\Controller\VerificationController::setDone', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($doneAction);

        $doneAction = new MassAction('Cancel', 'Admin\MembersBundle\Controller\VerificationController::setCancel', true, array('em' => $this->getDoctrine()->getManager()), null);
        $grid->addMassAction($doneAction);

        $grid->setDefaultOrder('updatedAt', 'ASC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param $primaryKeys
     * @param $allPrimaryKeys
     * @param $session
     * @param $parameters
     */
    public static function setWait($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];

        foreach ($primaryKeys as $memberId) {
            /* @var $verification Verification */
            $verification = $em->getRepository('UserBundle:Verification')->find($memberId);
            $verification->getUser()->setVerificationStatus(1);
            $em->flush();
        }
    }

    /**
     * @param $primaryKeys
     * @param $allPrimaryKeys
     * @param $session
     * @param $parameters
     */
    public static function setDone($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];

        foreach ($primaryKeys as $memberId) {
            /* @var $verification Verification */
            $verification = $em->getRepository('UserBundle:Verification')->find($memberId);
            $verification->getUser()->setVerificationStatus(2);
            $user = $verification->getUser();
//            $user->setRating($user->getRating() + 1);
            $em->flush();
        }
    }

    /**
     * @param $primaryKeys
     * @param $allPrimaryKeys
     * @param $session
     * @param $parameters
     */
    public static function setCancel($primaryKeys, $allPrimaryKeys, $session, $parameters)
    {
        /* @var $em EntityManager */
        $em = $parameters['em'];

        foreach ($primaryKeys as $memberId) {
            /* @var $verification Verification */
            $verification = $em->getRepository('UserBundle:Verification')->find($memberId);
            $verification->getUser()->setVerificationStatus(3);
            $em->flush();
        }
    }
}
