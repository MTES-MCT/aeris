<?php

namespace App\Form;

use App\Entity\Declaration\DeclarationDechets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeclarationDechetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qtiteIncinereeTotale')
            ->add('qtiteIncinereeDechetsDangereux')
            ->add('qtiteIncinereeDechetsDasri')
            ->add('qtiteIncinereeDechetsNonDangereux')
            ->add('qtiteIncinereeDechetsNonDangereuxMenagers')
            ->add('qtiteIncinereeDechetsNonDangereuxRefusTri')
            ->add('qtiteIncinereeDechetsNonDangereuxDae')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarationDechets::class,
        ]);
    }
}
