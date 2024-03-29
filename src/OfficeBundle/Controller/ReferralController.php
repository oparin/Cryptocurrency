<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.02.2016
 * Time: 11:38
 */

namespace OfficeBundle\Controller;

use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ReferralController
 * @package OfficeBundle\Controller
 */
class ReferralController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/referrals-my-referrals", name="referrals_my_referrals")
     * @Template("OfficeBundle:Referrals:my_referrals.html.twig")
     */
    public function myReferralsAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

//        $queryBuilder = $em->getRepository('UserBundle:User')->createQueryBuilder('u');
//        $queryBuilder
//            ->where('u.sponsor = :sponsor')
//            ->setParameter('sponsor', $this->getUser());
//        $adapter = new DoctrineORMAdapter($queryBuilder);
//        $pagerFanta = new Pagerfanta($adapter);
//        $page = $request->get('page', 1);
//        $pagerFanta->setMaxPerPage(12);
//        try {
//            $pagerFanta->setCurrentPage($page);
//        } catch (NotValidCurrentPageException $e) {
//            throw new NotFoundHttpException();
//        }
//        $pagerFanta->haveToPaginate();

//        return array(
//            'users' => $pagerFanta,
//        );
        $source = new Entity('UserBundle:User');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
//                    ->leftJoin($tableAlias.'.user', 's')
                    ->andWhere($tableAlias.'.sponsor = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'emailCanonical',
            'enabled',
            'salt',
            'password',
            'lastLogin',
            'confirmationToken',
            'passwordRequestedAt',
            'locked',
            'expired',
            'expiresAt',
            'roles',
            'credentialsExpired',
            'credentialsExpireAt',
            'referer',
            'registrationIp',
            'lastIp',
            'registrationFee',
            'debt',
            'verificationStatus',
            'fullName',
            'country',
            'city',
            'address',
            'usernameCanonical',
        ));

        $translator = $this->get('translator');
        $grid->getColumn('username')->setTitle($translator->trans('office.referrals.username'));
        $grid->getColumn('email')->setTitle('Email');
        $grid->getColumn('skype')->setTitle('Skype');
        $grid->getColumn('registrationDate')->setTitle($translator->trans('office.referrals.registrationDate'));
        $grid->getColumn('phone')->setTitle($translator->trans('home.registration.phone'));

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @return array
     *
     * @Route("/referrals-statistic", name="referrals_statistic")
     * @Template("OfficeBundle:Referrals:statistic.html.twig")
     */
    public function referralsStatisticAction()
    {
        $source = new Entity('StatisticBundle:SponsorBonusStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->leftJoin($tableAlias.'.user', 's')
                    ->andWhere('s.sponsor = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $translator = $this->get('translator');

        $sponsor = new TextColumn(array(
            'id'        => 'sponsor',
            'field'     => 'user.username',
            'source'    => true,
            'title'     => $translator->trans('office.referrals.username'),
        ));
        $grid->addColumn($sponsor, 1);

        $grid->getColumn('date')->setTitle($translator->trans('office.referrals.date'));
        $grid->getColumn('bonus')->setTitle($translator->trans('office.referrals.bonus'));

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}