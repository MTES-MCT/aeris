<?php

namespace App\Form;

use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\DeclarationDechets;
use App\Entity\Declaration\MesureDioxine;
use App\Form\DeclarationDechetsType;
use App\Form\MesureDioxineType;
use App\Form\DeclarationFonctionnementLigneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DeclarationIncinerateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('declarationDechets', 
                DeclarationDechetsType::class
            )
            ->add(
                'declarationsFonctionnementLigne',
                CollectionType::class,
                [
                    'entry_type' => DeclarationFonctionnementLigneType::class,
                    'entry_options' => array('label' => false),
                ]
            )
            ->add('declarationMonth',
                DateType::class,
                [
                    'data' => new \DateTime('first day of this month')
                ])
            ->add('methodeDeclaration', ChoiceType::class, [
                    'label' =>  'Méthode de saisie',
                    'choices'  => [
                        'form.declaration.choice.model_dreal' => DeclarationIncinerateur::METHOD_DREAL,
                        'form.declaration.choice.model_meac' => DeclarationIncinerateur::METHOD_MEAC,
                        'form.declaration.choice.model_wex' => DeclarationIncinerateur::METHOD_WEX,
                    ]
                ])
            ->add('declarationFile', VichFileType::class, [
                    'required' => false
                ])
            ->add('comment')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarationIncinerateur::class,
        ]);
    }
}
