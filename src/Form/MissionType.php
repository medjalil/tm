<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Mission;
use App\Entity\School;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('newMonth', TextType::class, [
                'label' => 'عدد الأشهر',
            ])
            ->add('newDay', TextType::class, [
                'label' => 'عدد الأيام',
            ])
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
                'label' => 'تاريخ النهاية',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('school', EntityType::class, [
                'label' => 'المؤسسة',
                'class' => School::class,
                'choice_label' => 'name',
            ])
            ->add('city', EntityType::class, [
                'label' => 'المعتمدية',
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'نوع النيابة',
                'choices' => [
                    'ظرفية' => '0',
                    'شغور' => '1'
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
            'translation_domain' => false
        ]);
    }


}
