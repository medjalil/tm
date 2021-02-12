<?php

namespace App\Form;

use App\Entity\Salary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'label' => ' تاريخ البداية',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'label' => ' تاريخ النهاية',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('days', IntegerType::class, [
                'label' => ' عدد الأيام المنجزة',
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'المبلغ',
                'currency' => 'TND',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salary::class,
            'translation_domain' => false
        ]);
    }
}
