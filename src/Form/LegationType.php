<?php

namespace App\Form;

use App\Entity\Legation;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'اسم المندوبية'
            ])
            ->add('phone', TextType::class, [
                'label' => 'الهاتف	'
            ])
            ->add('region', EntityType::class, [
                'label' => 'الولاية',
                'class' => Region::class,
                'choice_label' => 'name',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'العنوان',
                'required' => false,
                'attr' => [
                    'rows' => 5
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Legation::class,
            'translation_domain' => false
        ]);
    }
}
