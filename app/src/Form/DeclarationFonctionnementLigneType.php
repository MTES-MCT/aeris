<?php

namespace App\Form;

use App\Entity\Declaration\DeclarationFonctionnementLigne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeclarationFonctionnementLigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbHeuresFonctionnementTh')
            ->add('nbHeuresFonctionnementReel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarationFonctionnementLigne::class,
        ]);
    }
}
