<?php

namespace App\Form;

use App\Entity\Arome;
use App\Entity\Color;
use App\Entity\Gout;
use App\Entity\Region;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class GoutType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'nameColor',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('arome', EntityType::class, [
                'class' => Arome::class,
                'choice_label' => 'nameArome',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nameRegion',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gout::class,
        ]);
    }
}
