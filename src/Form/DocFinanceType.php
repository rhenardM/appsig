<?php

namespace App\Form;

use App\Entity\DocFinance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class DocFinanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('objet')
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
            'data_class' => DocFinance::class,
        ]);
    }
}
