<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/7/16
 * Time: 10:13 AM
 */

namespace Admin\CareerBundle\Controller;

use Admin\CareerBundle\Form\Type\RankFormType;
use Admin\WalletBundle\Grid\Column\StatusColumn;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\TextColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class CareerController
 * @package Admin\CareerBundle\Controller
 */
class CareerController extends Controller
{
    /**
     * @param Request $request
     * @param null    $id
     * @return array
     *
     * @Route("/settings/{id}", name="career_settings")
     * @Template("AdminCareerBundle::career_settings.html.twig")
     */
    public function calculatePointsAction(Request $request, $id = null)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $ranks = $em->getRepository('AdminCareerBundle:Rank')->findBy(array(), array('id' => 'ASC'));

        $rank = ($id) ? $em->getRepository('AdminCareerBundle:Rank')->find($id) : null;

        $form = $this->createForm(new RankFormType(), $rank);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->flush($data);

                $this->addFlash('success', 'Сохранено!');

                return $this->redirectToRoute('career_settings');
            }
        }

        return array(
            'ranks' => $ranks,
            'form'  => $form->createView(),
        );
    }

    /**
     * @return array
     *
     * @Route("/success-ranks", name="career_success_ranks")
     * @Template("AdminCareerBundle::success_ranks.html.twig")
     */
    public function successRanks()
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $source = new Entity('AdminCareerBundle:SuccessRank');
        $grid   = $this->get('grid');

        $grid->setSource($source);

        $grid->hideColumns(array(
            'id',
            'status',
            'comment',
        ));

        $member = new TextColumn(
            array(
                'id'        => 'user',
                'field'     => 'user.username',
                'title'     => 'Логин',
                'source'    => true,
                'size'      => 100,
            )
        );
        $grid->addColumn($member, 1);
        $grid->getColumn('status')->setSize(100);

        $statusColumn = new StatusColumn(array(
            'id'        => 'status',
            'title'     => 'status',
        ));
        $grid->addColumn($statusColumn);

        $editAction = new RowAction('edit', 'career_add_bonus');
        $editAction->setRouteParameters(array('id'));
        $grid->addRowAction($editAction);

        $grid->setDefaultOrder('id', 'DESC');

        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid'  => $grid,
        );
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return array
     *
     * @Route("/rank-add-bonus/{id}", name="career_add_bonus")
     * @Template("AdminCareerBundle::career_add_bonus.html.twig")
     */
    public function addBonusAction(Request $request, $id)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $rank = $em->getRepository('AdminCareerBundle:SuccessRank')->find($id);

        $form = $this->createFormBuilder()
            ->add('sum', 'money', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('comment', 'textarea', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $sum        = $form->get('sum')->getData();
                $comment    = $form->get('comment')->getData();
                $member = $rank->getUser();
                $wallets = $member->getWallets();
                $wallet = $wallets[0];
                $wallet->setSum($wallet->getSum() + $sum);
                $rank->setComment($comment);
                $rank->setStatus(true);
                $em->flush();

                $this->addFlash('success', 'Сохранено!');

                return $this->redirectToRoute('career_success_ranks');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }
}
