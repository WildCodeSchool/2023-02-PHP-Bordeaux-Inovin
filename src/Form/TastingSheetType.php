<?php

namespace App\Form;

use App\Entity\Smell;
use App\Entity\Taste;
use App\Entity\TastingSheet;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TastingSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intensity', ChoiceType::class, [
                'choices' => [
                    'limpide' => 'Limpide',
                    'opalescence' => 'Opalescence',
                    'voilee' => 'Voilée',
                ],
            ])
            ->add('clarity', ChoiceType::class, [
                'choices' => [
                    'etincelance' => 'Etincelance',
                    'eclatante' => 'Eclatante',
                    'brillance' => 'Brillance',
                ],
            ])
            ->add('color', TextType::class)
            ->add('smell', EntityType::class, [
                'class' => Smell::class,
                'choice_label' => 'nameSmell',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('taste', EntityType::class, [
                'class' => Taste::class,
                'choice_label' => 'nameTaste',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('comment', TextareaType::class)
            ->add('wine', TextType::class)
            ->add('workshop', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TastingSheet::class,
        ]);
    }
}
