<?php

namespace App\Form;

use App\Entity\Disc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class NewDiscType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                    'attr' => [
                    'placeholder' => 'Titre',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[123]+$/',
                        'message' => 'Caractère(s) non valide(s)',
                        'match' => 'true'
                    ]),
                ],
            ])
            ->add('artist')
            ->add('year', IntegerType::class, [
                'label' => 'Année',                
                'attr' => [
                    'placeholder' => 'Année'
                ],
            ])
            ->add('genre', TextType::class, [
                'label' => 'Genre',                
                'attr' => [
                    'placeholder' => 'Genre',
                ],
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',                
                'attr' => [
                    'placeholder' => 'Label',
                ],
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix',                
                'attr' => [
                    'placeholder' => 'Prix',
                ],
            ])
            ->add('picture')
            ->add('submit', SubmitType::class)
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Disc::class,
        ]);
    }
}
