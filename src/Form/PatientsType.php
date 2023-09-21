<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('adress')
            ->add('phone')
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'w-100 rounded-3 py-1 px-2'],
            ])
            ->add('numSecu')
            ->add('genre')
            ->add('infoSupAdress')
            ->add('fullNameMedecinTraitant')
            ->add('PhoneMedecinTraitant')
            ->add('PharmacieName')
            ->add('PhonePharmacie')
            ->add('fullNameUrgentContact')
            ->add('phoneUrgentContact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
