<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\TypeRec;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_rec')
            ->add('description_rec')
            ->add('type', EntityType::class, [
                'class' => TypeRec::class,
                'label' => 'id_type',
                'attr' => [
                    'class' => 'form-control my-custom-class',
                    'style' => 'color: red; font-family: Cambria;'
                ]
            ])
           ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
