<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'البريد الالكتروني'
            ])
            ->add('fullName', TextType::class, [
                'label' => 'الاسم و اللقب'
            ])
            ->add('mobile', NumberType::class, [
                'label' => 'الهاتف'
            ])
            ->add('password', TextType::class, [
                'label' => 'كلمة المرور الأساسية',
                'mapped' => false,
                'attr' => [
                    'value' => 'diptunisie123',
                    'readonly' => true
                ]])
            ->add('roles', ChoiceType::class,
                [
                    'label' => 'نوع الحساب',
                    'multiple' => true,
                    'expanded' => false,
                    'choices' => [
                        'الإدارة' => 'ROLE_MANGER',
                        'المالية' => 'ROLE_ACCOUNT',
                        'المشاهدة' => 'ROLE_WATCH'
                    ]
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => false
        ]);
    }
}
