<?php

namespace App\DataFixtures;

use App\Entity\TastingSheet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TastingSheetFixtures extends Fixture implements DependentFixtureInterface
{
    public const SMELLS = [
        'Fleurs',
        'Bois',
        'Fruits',
        'Epices',
        'Animal',
        'Défauts',
    ];

    public const TASTES = [
        'Acidité',
        'Gras',
        'Amer',
        'Alcool',
        'Sucre',
        'Défauts',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $tastingSheet = new TastingSheet();
            $tastingSheet
                ->setColor($faker->word)
                ->setClarity($faker->word)
                ->setIntensity($faker->word)
                ->setWine($this->getReference('wine_' . rand(1, 49)))
                ->setComment($this->getReference('comment_' . rand(0, 49)))
                ->addTaste($this->getReference('taste_' . self::TASTES[rand(0, 5)]))
                ->addSmell($this->getReference('smell_' . self::SMELLS[rand(0, 5)]));
            $manager->persist($tastingSheet);
            $this->addReference('tastingSheet_' . $i, $tastingSheet);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CepageFixtures::class,
            CommentFixtures::class,
            TasteFixtures::class,
            SmellFixtures::class,
        ];
    }
}
