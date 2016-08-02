<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 5/18/16
 * Time: 11:37 AM
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ProfileFormType
 * @package UserBundle\Form\Type
 */
class ProfileFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('username');
        $builder->remove('email');
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
        return 'fos_user_profile';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'user_profile';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
