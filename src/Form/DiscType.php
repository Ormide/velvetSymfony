<?php

namespace App\Form;

use App\Entity\Disc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class DiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9,\s]+$/',
                        'message' => 'Caractère(s) non valide(s)',
                    ])
                ]
            ])
            ->add('artist')
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'attr' => [
                    'placeholder' => 'Année'
                ],
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
                'label' => 'Genre',
                'attr' => [
                    'placeholder' => 'Genre'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un genre'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',
                'attr' => [
                    'placeholder' => 'Label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un label'
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9,\s]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Prix'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prix'
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('picture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disc::class,
        ]);
    }
}
