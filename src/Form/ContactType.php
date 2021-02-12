<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'الموضوع',
                'attr' => [
                    'placeholder' => 'يمكنك كتابة الموضوع هنا..'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'الرسالة',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'نص المراسلة..'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'translation_domain' => false
        ]);
    }
}
