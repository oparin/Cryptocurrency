<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/21/16
 * Time: 4:29 PM
 */

namespace MarketingBundle\Controller;

use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Row;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UserBundle\Entity\User;

/**
 * Class StatisticController
 * @package MarketingBundle\Controller
 */
class StatisticController extends Controller
{
    /**
     * @return array
     *
     * @Route("/binary-statistic", name="marketing_binary_statistic")
     * @Template("MarketingBundle:Statistic:statistic.html.twig")
     */
    public function myBinaryAction()
    {
        /** @var $user User */
        $user = $this->getUser();

        return array(
            'statistics'    => $user->getStatisticPoints(),
        );
    }

    /**
     * @return array
     *
     * @Route("/scale-statistic", name="marketing_scale_statistic")
     * @Template("MarketingBundle:Statistic:scale_statistic.html.twig")
     */
    public function myScaleAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $source = new Entity('StatisticBundle:ScaleBonusStatistic');
        $grid   = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.userTo = :user')
                    ->addGroupBy($tableAlias.'.date')
                    ->setParameter('user', $this->getUser());
            }
        );
        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'level',
            'bonus',
        ));

        $translator = $this->get('translator');
        $grid->getColumn('date')->setTitle($translator->trans('office.affiliate_program.history.date'));
        $grid->getColumn('bonus')->setTitle($translator->trans('office.affiliate_program.history.bonus'));

        $sum = new TextColumn(array(
            'id'        => 'sum',
            'title'     => $translator->trans('office.deposit.sum'),
        ));
        $sum->manipulateRenderCell(
            function ($value, $row, $router) use ($em, $user) {
                $date = $row->getField('date');
                $qb = $em->getRepository('StatisticBundle:ScaleBonusStatistic')->createQueryBuilder('sbs');
                $qb
                    ->select('SUM(sbs.bonus)')
                    ->where('sbs.date = :date')
                    ->andWhere('sbs.userTo = :user')
                    ->setParameter('date', $date)
                    ->setParameter('user', $user);

                return ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;
            }
        );
        $grid->addColumn($sum);

        $levels = $em->getRepository('AdminMarketingBundle:SettingsScale')->findAll();
        for ($i = 1; $i < count($levels) + 1; $i++) {
            $level = new TextColumn(array(
                'id' => 'level'.$i,
                'title' => $translator->trans('office.affiliate_program.scale.level').' '.$i,
            ));
            $level->manipulateRenderCell(
                function ($value, $row, $router) use ($em, $i) {
                    $date = $row->getField('date');
                    $qb = $em->getRepository('StatisticBundle:ScaleBonusStatistic')->createQueryBuilder('sbs');
                    $qb
                        ->select('SUM(sbs.bonus)')
                        ->where('sbs.date = :date')
                        ->andWhere('sbs.level = :level')
                        ->setParameter('date', $date)
                        ->setParameter('level', $i);

                    return ($qb->getQuery()->getSingleScalarResult()) ? $qb->getQuery()->getSingleScalarResult() : 0;
                }
            );
            $grid->addColumn($level, $i + 2);
        }

        $detailsAction = new RowAction('details', 'marketing_scale_statistic_details');
        $detailsAction->manipulateRender(
            function ($action, $row) {
                /** @var $action RowAction */
                $date = $row->getField('date');
                $action->setRouteParameters(array('date' => $date->format('Y-m-d')));
                $action->setTitle('Details');

                return $action;
            }
        );
        $grid->addRowAction($detailsAction);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param  string $date
     * @return array
     *
     * @Route("/scale-statistic-details/{date}", name="marketing_scale_statistic_details")
     * @Template("MarketingBundle:Statistic:scale_statistic_details.html.twig")
     */
    public function detailsAction($date)
    {
        $date = new \DateTime($date);
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $levels = $em->getRepository('AdminMarketingBundle:SettingsScale')->findAll();
        $stats = array();
        for ($i = 1; $i < count($levels) + 1; $i++) {
            $rows = $em->getRepository('StatisticBundle:ScaleBonusStatistic')->findBy(array(
                'userTo'    => $user,
                'level'     => $i,
            ));
            $stats[]    = $rows;
        }
//        dump(($stats));exit;
        return array(
            'date'  => $date,
            'stats' => $stats,
        );
    }
}
