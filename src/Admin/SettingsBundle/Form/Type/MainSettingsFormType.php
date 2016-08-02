<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 10:08
 */

namespace Admin\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MainSettingsFormType
 * @package Admin\SettingsBundle\Form\Type
 */
class MainSettingsFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hostName', 'text', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('registrationFee', 'money', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('minWithdraw', 'money', array(
                'constraints'   => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\SettingsBundle\Entity\MainSettings',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'main_settings_form_type';
    }
}
