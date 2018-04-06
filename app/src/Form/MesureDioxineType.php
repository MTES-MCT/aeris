<?php

namespace App\Form;

use App\Entity\Declaration\MesureDioxine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MesureDioxineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLaboratoire', TextType::class)
            ->add('dateDebut', DateType::class, ['widget' => 'single_text'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text'])
            ->add('disponibiliteLigne', NumberType::class)
            ->add('disponibiliteAnalyseur', NumberType::class)
            ->add('concentration')
            ->add('commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MesureDioxine::class,
        ]);
    }
}
