<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 20.01.16
 * Time: 20:38
 */

namespace Admin\MembersBundle\Form\Type;

use Admin\MembersBundle\Form\DataTransformer\UserToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class MemberFormType
 * @package Admin\MembersBundle
 */
class MemberFormType extends AbstractType
{
    private $manager;

    /**
     * MemberFormType constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('email', 'text', array(
                'constraints'   => array(new NotBlank()),
            ))
            ->add('sponsor', 'text', array(
                'required'  => false,
            ));

        $builder->get('sponsor')
            ->addModelTransformer(new UserToStringTransformer($this->manager));

        $builder
            ->add('wallets', 'collection', array(
                'type' => new UserWalletFormType(),
            ))
            ->add('accounts', 'collection', array(
                'type' => new UserAccountFormType(),
            ))
            ->add('credits', 'collection', array(
                'type' => new UserCreditFormType(),
            ))
            ->add('profits', 'collection', array(
                'type' => new UserProfitFormType(),
            ))
            ->add('enabled', 'checkbox', array(
                'required'  => false,
            ))
            ->add('locked', 'checkbox', array(
                'required'  => false,
            ))
            ->add('registrationDate', 'date', array(
                'widget'    => 'single_text',
                'format'    => 'dd-MM-yyyy',
                'attr'      => array('class' => 'datepicker'),
                'constraints'   => array(new NotBlank()),
            ))
            ->add('last_login', 'date', array(
                'widget'    => 'single_text',
                'format'    => 'dd-MM-yyyy',
                'attr'      => array('class' => 'datepicker'),
                'constraints'   => array(new NotBlank()),
            ))
            ->add('registrationIp', 'text', array(
                'required'  => false,
                'attr'      => array('readonly' => 'readonly'),
            ))
            ->add('lastIp', 'text', array(
                'required'  => false,
                'attr'      => array('readonly' => 'readonly'),
            ))
            ->add('plain_password', 'repeated', array(
                'required'  => false,
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'member_form_type';
    }
}
