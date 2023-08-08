<?php

namespace App\Form;

use App\Entity\DocLettre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DocLettreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('objet')
            ->add('provenace')
            ->add('file',  FileType::class, [
                'label' => 'Choisir un fichier',
                'attr' => [
                    'class' => 'form-control-file'
                ]
            ])
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DocLettre::class,
        ]);
    }
}
