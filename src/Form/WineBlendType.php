<?php

namespace App\Form;

use App\Entity\WineBlend;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineBlendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameBlend', TextType::class, [
                "label" => false,
            ])
            ->add('percentageCepage1')
            ->add('percentageCepage2')
            ->add('percentageCepage3')
            ->add('percentageCepage4')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WineBlend::class,
        ]);
    }
}
