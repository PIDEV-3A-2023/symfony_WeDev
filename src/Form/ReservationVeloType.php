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
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3Validator;




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
            ]);
           // ->add('captcha', Recaptcha3Type::class, [
             //  'constraints' => new Recaptcha3 (),
              //      'message' => 'ReservationVelo',
    
           // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationVelo::class,
        ]);
    }
}
