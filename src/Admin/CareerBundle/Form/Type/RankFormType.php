<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 6/7/16
 * Time: 12:34 PM
 */

namespace Admin\CareerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RankFormType
 * @package Admin\CareerBundle\Form\Type
 */
class RankFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', 'file', array(
                'required' => false,
            ))
            ->add('name', 'text', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('reward', 'textarea', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('weakFoot', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('overallVolume', 'number', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('rank', 'entity', array(
                'class' => 'AdminCareerBundle:Rank',
                'choice_label' => 'name',
                'required'  => false,
            ))
            ->add('countReferrals', 'number', array(
                'constraints'   => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Admin\CareerBundle\Entity\Rank',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rank_form_type';
    }
}
