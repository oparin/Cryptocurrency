<?php

namespace Admin\StaticPageBundle\Controller;

use Admin\StaticPageBundle\Form\Type\StaticPagesFormType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class StaticPageController extends Controller
{
    /**
     * @return array
     *
     * @Route("/all-pages", name="static_page_all_pages")
     * @Template("AdminStaticPageBundle::all_pages.html.twig")
     */
    public function allPagesAction()
    {
        $source = new Entity('AdminStaticPageBundle:StaticPage');
        $grid = $this->get('grid');
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function ($query) use ($tableAlias) {
                /* @var $query \Doctrine\ORM\QueryBuilder */
                $query
                    ->groupBy($tableAlias.'.title');
            }
        );
        $grid->setSource($source);
        $grid->hideColumns(array(
            'id',
            'text',
            'locale',
        ));

        $grid->getColumn('title')->setTitle('Title');

        $editAction = new RowAction('edit', 'static_page_edit_page');
        $editAction->setRouteParameters(array('title'));
        $grid->addRowAction($editAction);

        $grid->setDefaultOrder('id', 'ASC');
        $grid->setLimits(20);
        if ($grid->isReadyForRedirect()) {
            return new RedirectResponse($grid->getRouteUrl());
        }

        return array(
            'grid' => $grid,
        );
    }

    /**
     * @param Request $request
     * @param string  $title
     * @return array|RedirectResponse
     *
     * @Route("/edit-page/{title}", name="static_page_edit_page")
     * @Template("AdminStaticPageBundle::edit_page.html.twig")
     */
    public function editAction(Request $request, $title)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('AdminStaticPageBundle:StaticPage')->findBy(array(
            'title' => $title,
        ));

        $form = $this->createForm(new StaticPagesFormType(), $pages);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $staticPages = $form->getData();
                foreach ($staticPages as $staticPage) {
                    $em->persist($staticPage);
                }

                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Success!'
                );

                return $this->redirect($this->generateUrl('static_page_edit_page', array('title' => $title)));
            }
        }

        return array(
            'form'  => $form->createView(),
            'title' => $title,
        );
    }
}
