<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEvent', null, [
        'constraints' => [
            new NotBlank([
                'message' => 'Le nom de l\'événement est obligatoire'
            ]),
        ],
    ])
->add('dateEvent', DateType::class, [
    'widget' => 'single_text',
    'format' => 'yyyy-MM-dd',
])


            ->add('locateEvent', null, [
    'constraints' => [
        new NotBlank(),
    ],
])

->add('photoEvent', FileType::class, [
    'required' => false,
    'data_class' => null,
    'constraints' => [
        new File([
            'maxSize' => '1024k',
            'mimeTypes' => [
                'image/jpeg',
                'image/png',
                'image/gif',
            ],
            'mimeTypesMessage' => 'Veuillez uploader une image valide (jpeg, png, gif)',
        ]),
    ],
])

             
        ->add('dispoplaceEvent', null, [
    'constraints' => [
        new GreaterThan(0),
    ],
])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            
        ]);
    }
}
