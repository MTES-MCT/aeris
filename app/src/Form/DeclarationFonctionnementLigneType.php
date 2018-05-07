<?php

namespace App\Form;

use App\Entity\Declaration\DeclarationFonctionnementLigne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Type\FloatType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DeclarationFonctionnementLigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbHeuresFonctionnementTh', FloatType::class)
            ->add('nbHeuresFonctionnementReel', FloatType::class)
            ->add('declarationCompteursFile', VichFileType::class, [
                    'required' => false
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarationFonctionnementLigne::class,
        ]);
    }
}
