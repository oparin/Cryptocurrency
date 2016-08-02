<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/9/16
 * Time: 3:46 PM
 */

namespace Admin\FaqBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FaqFormType
 * @package Admin\FaqBundle
 */
class FaqFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'textarea', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('locale', 'text', array(
                'constraints' => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\FaqBundle\Entity\Faq',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'faq_form_type';
    }
}
