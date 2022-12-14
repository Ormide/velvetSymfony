<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z0-9.]+@[A-Za-z0-9]+.[A-Za-z]+$/',
                        'message' => 'Adresse e-mail non valide',
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse e-mail',
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'required' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le Mot de passe'],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractère(s).',
                        'max' => 16,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/(?!\s)^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/(?!\s)^[A-Za-z0-9éèàçâêûîôäëüïö\ ]+$/',
                        'message' => 'Caractère(s) non valide(s)'
                    ])
                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
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
            'data_class' => User::class,
        ]);
    }
}
