<?php

namespace App\Form;

use App\Entity\Velo;
use App\Entity\User;
use App\Entity\Station;
use App\Entity\ReservationVelo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ReservationVeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('nbr')
            ->add('prixr')
            ->add('idVelo', EntityType::class, [
                'class' => Velo::class,
                'choice_label' => 'titre',
            ])
            ->add('idStation', EntityType::class, [
                'class' => Station::class,
                'choice_label' => 'nomStation',
            ])
            ->add('iduser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nomuser',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationVelo::class,
        ]);
    }
}
