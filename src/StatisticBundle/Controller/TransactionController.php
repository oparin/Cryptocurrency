<?php

namespace StatisticBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class TransactionController
 * @package StatisticBundle\Controller
 */
class TransactionController extends Controller
{
    /**
     * @return array
     *
     * @Route("/transactions", name="statistic_transaction")
     * @Template("StatisticBundle:Transactions:transactions.html.twig")
     */
    public function transactionAction()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $source = new Entity('StatisticBundle:TransactionStatistic');
        $grid   = $this->get('grid');

        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->andWhere($tableAlias.'.user = :user')
                    ->setParameter('user', $this->getUser());
            }
        );

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $translator = $this->get('translator');

        $grid->getColumn('date')->setTitle($translator->trans('office.transactions.date'));
        $grid->getColumn('sum')->setTitle($translator->trans('office.transactions.sum'));
        $grid->getColumn('mainWallet')->setTitle($translator->trans('office.transactions.main_wallet'));
        $grid->getColumn('mainAccount')->setTitle($translator->trans('office.transactions.main_account'));
        $grid->getColumn('mainCredit')->setTitle($translator->trans('office.transactions.main_credit'));
        $grid->getColumn('mainProfit')->setTitle($translator->trans('office.transactions.units_profit'));
        $grid->getColumn('type')->setTitle($translator->trans('office.transactions.type'));

        $grid->getColumn('type')->manipulateRenderCell(
            function($value, $row, $router) use ($translator) {
                switch ($value) {
                    case 0:
                        $result = $translator->trans('office.transactions.withdraw');
                        break;
                    case 1:
                        $result = $translator->trans('office.transactions.deposit');
                        break;
                    case 2:
                        $result = $translator->trans('office.transactions.buy_status');
                        break;
                    case 3:
                        $result = $translator->trans('office.transactions.buy_debt');
                        break;
                    case 4:
                        $result = $translator->trans('office.transactions.convert_units');
                        break;
                    case 5:
                        $result = $translator->trans('office.transactions.profit_units');
                        break;
                    case 6:
                        $result = $translator->trans('office.transactions.refund_founds');
                        break;
                    default:
                        $result = $value;
                }

                return $result;
            }
        );

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }
}
