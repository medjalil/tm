<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Defines the custom form field type used to change user's password.
 *
 * @author Romain Monteil <monteil.romain@gmail.com>
 */
class ChangePasswordType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'translation_domain' => false,
                'constraints' => [
                    new UserPassword(),
                ],
                'label' => 'كلمة المرور الحالية',
                'attr' => [
                    'autocomplete' => 'off',
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'translation_domain' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'max' => 128,
                    ]),
                ],
                'first_options' => [
                    'label' => 'كلمة المرور الجديدة',
                ],
                'second_options' => [
                    'label' => 'تأكيد كلمة المرور الجديدة',
                ],
            ]);
    }

}
