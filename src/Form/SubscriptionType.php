<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Subscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('offer', EntityType::class, [
                'class' => Offer::class,
                'choice_label' => 'title',
                'label' => 'العرض'
            ])
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'label' => ' تاريخ بداية الاشتراك',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'label' => ' تاريخ نهاية الاشتراك',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
            'translation_domain' => false
        ]);
    }
}
