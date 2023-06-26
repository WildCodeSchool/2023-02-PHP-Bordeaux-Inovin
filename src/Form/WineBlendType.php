<?php

namespace App\Form;

use App\Entity\WineBlend;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineBlendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameBlend')
            ->add('scoreWineblend')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('user')
            ->add('workshop')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WineBlend::class,
        ]);
    }
}
