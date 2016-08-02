<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/8/16
 * Time: 2:32 PM
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationType
 * @package UserBundle\Form\Type
 */
class RegistrationFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', 'text', array(
                'required'  => false,
            ))
            ->add('country', 'country', array(
                'required'  => false,
            ))
            ->add('city', 'text', array(
                'required'  => false,
            ))
            ->add('address', 'text', array(
                'required'  => false,
            ))
            ->add('skype', 'text', array(
                'constraints' => array(new NotBlank()),
            ))
            ->add('phone', 'text', array(
                'constraints' => array(new NotBlank()),
            ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
         return 'fos_user_registration';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
