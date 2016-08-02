<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/31/16
 * Time: 4:16 PM
 */

namespace Admin\MarketingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SettingsScaleFormType
 * @package Admin\MarketingBundle\Form\Type
 */
class SettingsScaleFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('percent', 'number', array(
                'constraints'   => new NotBlank(),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\MarketingBundle\Entity\SettingsScale',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_scale_form';
    }
}
