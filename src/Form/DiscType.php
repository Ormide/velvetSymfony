<?php

namespace App\Form;

use App\Entity\Disc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)',
                    ])
                ]
            ])
            ->add('artist', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un artiste'
                    ])
                ]
            ])
            ->add('year', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une année'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{4}$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('genre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un genre'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('label', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un label'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('price', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prix'
                    ]),
                ]
            ])
            ->add('picture2', FileType::class, [
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
            'data_class' => Disc::class,
        ]);
    }
}
