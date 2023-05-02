<?php

namespace App\Form;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class StationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomStation')
            ->add('localisationStation', ChoiceType::class, [
                'choices' => [
                    'Tunis' => 'Tunis',
                    'Sfax' => 'Sfax',
                    'Sousse' => 'Sousse',
                    'Kairouan' => 'Kairouan',
                    'Bizerte' => 'Bizerte',
                    'Gabès' => 'Gabès',
                    'Ariana' => 'Ariana',
                    'Gafsa' => 'Gafsa',
                    'Monastir' => 'Monastir',
                    'Ben Arous' => 'Ben Arous',
                    'Kasserine' => 'Kasserine',
                    'Médenine' => 'Médenine',
                    'Nabeul' => 'Nabeul',
                    'Tataouine' => 'Tataouine',
                    'Béja' => 'Béja',
                    'Le Kef' => 'Le Kef',
                    'Mahdia' => 'Mahdia',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Jendouba' => 'Jendouba',
                    'Tozeur' => 'Tozeur',
                    'La Manouba' => 'La Manouba',
                    'Siliana' => 'Siliana',
                    'Zaghouan' => 'Zaghouan',
                    'Kébili' => 'Kébili',
                    // Ajoutez les villes que vous souhaitez proposer dans la liste déroulante
                ]
            ])
            ->add('veloStation')
            //->add('submit', SubmitType::class, [
                //'label' => 'Submit',]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Station::class,
        ]);
    }
}
