<?php

namespace App\Form;

use App\Entity\DeclarationIncinerateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DeclarationIncinerateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('declarationFile', VichFileType::class, [
                'required' => true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeclarationIncinerateur::class,
        ]);
    }
}
