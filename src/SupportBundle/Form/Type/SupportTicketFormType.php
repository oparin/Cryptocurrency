<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 21.03.16
 * Time: 18:08
 */

namespace SupportBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class SupportTicketFormType
 * @package SupportBundle\Form\Type
 */
class SupportTicketFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array(
                'label'         => 'support.subject',
                'constraints'   => array(new NotBlank()),
            ))
            ->add('text', 'textarea', array(
                'label'         => 'support.text',
                'constraints'   => array(new NotBlank()),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SupportBundle\Entity\SupportTicket',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'support_ticket_form_type';
    }
}
