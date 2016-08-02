<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/2/16
 * Time: 4:50 PM
 */

namespace Admin\CreditBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class CreditSettingsFormType
 * @package Admin\CreditBundle\Form\Type
 */
class CreditSettingsFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rate', 'money', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('percentConvert', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('periodConvert', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('percentProfit', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('percentWithdraw', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('periodWithdraw', 'number', array(
                'constraints'   => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CreditBundle\Entity\CreditSettings',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'credit_settings_form_type';
    }
}
