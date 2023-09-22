<?php

namespace App\Form\Meet;

use App\Entity\Meet;
use App\Entity\Patient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewMeetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('infoComplementaire', TextareaType::class, [
                'label'=>false,
                'required'=>false,
                'attr' => ['class' => 'w-100 rounded-3'],
            ])
            ->add('typeSoin', TextareaType::class, [
                'label'=>false,
                'attr' => ['class' => 'w-100 rounded-3'],
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'name',
                'label'=>false,
                'attr' => ['class' => 'w-100 rounded-3'],
            ])
            ->add('typePassage', ChoiceType::class, [
                'label'=>false,
                'expanded' => true,
                'choices'  => [
                    'Tous les jours' => 'Tous les jours',
                    'Tous les 3 jours' => 'Tous les 3 jours',
                ],
            ])
            ->add('hour', TimeType::class, [
                'label'=>false,
                'mapped'=>false,
                'widget' => 'single_text',
                'attr' => ['class' => 'w-100 rounded-3 py-1 px-2'],
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'label'=>false,
                'attr' => ['class' => 'w-100 rounded-3 py-1 px-2'],
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'label'=>false,
                'attr' => ['class' => 'w-100 rounded-3 py-1 px-2'],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meet::class,
        ]);
    }
}