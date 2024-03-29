<?php

namespace App\Form;

use App\Entity\Smell;
use App\Entity\Taste;
use App\Entity\TastingSheet;
use App\Entity\Wine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseTastingSheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intensity', ChoiceType::class, [
                'choices' => [
                    'Limpide' => 'limpide',
                    'Opalescence' => 'opalescence',
                    'Voilée' => 'voilée',
                    'Trouble' => 'trouble',
                ],
            ])
            ->add('clarity', ChoiceType::class, [
                'choices' => [
                    'Étincelante' => 'étincelante',
                    'Éclatante' => 'éclatante',
                    'Brillance' => 'brillance',
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
            ->add('wine', EntityType::class, [
                'class' => Wine::class,
                'choice_label' => 'id',
                'attr' => [
                    'hidden' => true
                ],
            ])
            ->add('scoreTastingSheet', ChoiceType::class, [
                'choices'  => [

                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10'=> 10,

                ],
                'label' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'class' => 'form-control',
                ],
                'expanded' => true,

            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TastingSheet::class,
        ]);
    }
}
