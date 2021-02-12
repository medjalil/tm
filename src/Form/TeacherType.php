<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('fullName', TextType::class, ['label' => 'الاسم و اللقب'])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'label' => ' تاريخ الولادة',
                'html5' => false,
                'format' => 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'datepicker',
                    'autocomplete' => 'off'
                ]
            ])
            ->add('cin', TextType::class, ['label' => 'رقم بطاقة تعريف وطنية'])
            ->add('phone', TextType::class, ['label' => 'الهاتف الجوال'])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'label' => 'المعتمدية'
            ])
            ->add('diplomaAt', NumberType::class, ['label' => 'سنة التخرج'])
            ->add('pId', NumberType::class, ['label' => 'المعرف الوحيد', 'required' => false])
            ->add('bankId', NumberType::class, ['label' => 'المعرف البريدي أو البنكي', 'required' => false])
            ->add('initMonth', NumberType::class, ['label' => 'الاشهر القديمة'])
            ->add('initDay', NumberType::class, ['label' => 'الايام القديمة'])
            ->add('ord', NumberType::class, ['label' => 'الترتيب'])
            ->add('address', TextareaType::class, ['label' => 'العنوان', 'required' => false])
            ->add('comment', TextareaType::class, ['label' => 'الملاحظات', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
            'translation_domain' => false
        ]);
    }
}
