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

            ])
            ->add('typeSoin', TextareaType::class, [

            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'name',
            ])
            ->add('typePassage', ChoiceType::class, [
                'choices'  => [
                    'Tous les jours' => 'Tous les jours',
                    'Tous les 3 jours' => 'Tous les 3 jours',
                ],
            ])
            ->add('hour', TimeType::class, [
                'mapped'=>false,
            ])
            ->add('date_debut', DateType::class, [

            ])
            ->add('date_fin', DateType::class, [

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