<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/16/16
 * Time: 4:40 PM
 */

namespace Admin\StaticPageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class StaticPagesFormType
 * @package Admin\StaticPageBundle\From\Type
 */
class StaticPagesFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        dump($options);exit;
        $builder->add('page', 'collection', array(
            'type'      => new StaticPageFormType(),
            'data'      => $options['data'],
            'mapped'    => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'static_pages_form_type';
    }
}
