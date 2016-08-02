<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/16/16
 * Time: 4:32 PM
 */

namespace Admin\StaticPageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class StaticPageFormType
 * @package Admin\StaticPageBundle\From\Type
 */
class StaticPageFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'textarea', array(
            'attr'  => array(
                'class' => "tinymce",
                'rows'  => 20
            ),
            'label_attr' => array(
                'display' => 'none'
            ),
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\StaticPageBundle\Entity\StaticPage',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'static_page_form_type';
    }
}
