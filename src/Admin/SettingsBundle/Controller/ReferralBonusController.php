<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.02.16
 * Time: 9:51
 */

namespace Admin\SettingsBundle\Controller;

use Admin\SettingsBundle\Form\Type\ReferralBonusFormType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReferralBonusController
 * @package Admin\SettingsBundle\Controller
 */
class ReferralBonusController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/referral-bonus/{id}", name="referral_bonus_settings")
     * @Template("AdminSettingsBundle:ReferralBonus:referral_bonus_settings.html.twig")
     */
    public function referralBonusSettingsAction(Request $request, $id = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();

        $profits = $em->getRepository('AdminSettingsBundle:ReferralBonus')->findAll();

        $profit = ($id) ? $profit = $em->getRepository('AdminSettingsBundle:ReferralBonus')->find($id) : null;

        $form = $this->createForm(new ReferralBonusFormType(), $profit);

        $source = new Entity('AdminSettingsBundle:ReferralBonus');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
        ));

        $bonusFrom = new TextColumn(array(
            'id'        => 'statusFrom',
            'field'     => 'statusFrom.name',
            'source'    => true,
            'title'     => 'Статус (от кого)',
            'size'      => 200,
        ));
        $grid->addColumn($bonusFrom, 1);

        $bonusTo = new TextColumn(array(
            'id'        => 'statusTo',
            'field'     => 'statusTo.name',
            'source'    => true,
            'title'     => 'Статус (от кому)',
            'size'      => 200,
        ));
        $grid->addColumn($bonusTo, 1);

        $translator = $this->get('translator');

        $grid->getColumn('bonus')->setTitle('Бонус');

        $editAction = new RowAction('edit', 'referral_bonus_settings');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

//        $deleteAction = new RowAction('delete', 'settings_members_status_delete', true);
//        $deleteAction->setRouteParameters(array('id'));
//        $deleteAction->setConfirmMessage($translator->trans('members.delete_confirm_message'));
//        $grid->addRowAction($deleteAction);

        $grid->setDefaultOrder('id', 'DESC');
        $grid->setLimits(array(50, 100, 200));

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            /* @var $data \Admin\MarketingBundle\Entity\BinaryProfit */
            $data = $form->getData();

            $exist = $em->getRepository('AdminSettingsBundle:ReferralBonus')->findOneBy(array(
                'statusFrom'   => $data->getStatusFrom(),
                'statusTo'     => $data->getStatusTo(),
            ));

            if ($exist && !$id) {
                $form->addError(new FormError('Уже существует!'));
            }

            if ($form->isValid()) {
                $em->persist($data);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Сохранено!'
                );

                return $this->redirect($this->generateUrl('referral_bonus_settings'));
            }
        }

        return array(
            'profits'   => $profits,
            'form'      => $form->createView(),
            'grid'      => $grid,
        );
    }
}
