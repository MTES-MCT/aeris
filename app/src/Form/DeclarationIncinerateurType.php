<?php

namespace App\Form;

use App\Entity\Declaration\DeclarationIncinerateur;
use App\Entity\Declaration\declarationDechets;
use App\Form\DeclarationDechetsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DeclarationIncinerateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('declarationDechets', 
                DeclarationDechetsType::class
            )
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
