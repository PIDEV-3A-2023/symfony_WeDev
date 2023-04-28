<?php

namespace App\Form;

use App\Entity\Velo;
use App\Entity\Categorie;
use App\Entity\Station;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class VeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('prix')
            ->add('image', FileType::class, ['required' => false])
            ->add('qte')
            ->add('idCategorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nomCategorie',
            ])
            ->add('idStation', EntityType::class, [
                'class' => Station::class,
                'choice_label' => 'nomStation',
            ])
        ;
    }
    
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}
