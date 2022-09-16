<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'artiste',
                'attr' => [
                    'placeholder' => 'Nom de l\'artiste',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un label'
                    ]),
                    new Regex([
                        'pattern' => '/(?!\s)^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('url', TextType::class, [
                'label' => 'Site web de l\'artiste',
                'attr' => [
                    'placeholder' => 'Site web de l\'artiste',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',
                        'message' => 'caractère(s) non valide(s)',
                    ])
                ]
            ])
            ->add('picture2', FileType::class, [
                'label' => 'Image de l\'artist',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpg', 'image/jpeg', 'image/png'
                        ],
                        'mimeTypesMessage' => 'Inserez une image au format jpg, jpeg ou png'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
