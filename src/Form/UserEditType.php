<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 50,
                ],
                'constraints' => [
                    new Length(null, 2, 50, 'Votre prénom doit contenir entre 2 et 50 caractères'),
                ]
            ])
            ->add('lastname', TextType::class, [
                    'attr' => [
                        'minlength' => 2,
                        'maxlength' => 50,
                    ],
                    'constraints' => [
                        new Length(null, 2, 50, 'Votre prénom doit contenir entre 2 et 50 caractères'),
                    ]
                ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez une date de naissance',
                    ]),
                ]
            ])
            ->add('zipcode', IntegerType::class)
            ->add('phoneNumber', TextType::class)
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez une adresse email',
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
