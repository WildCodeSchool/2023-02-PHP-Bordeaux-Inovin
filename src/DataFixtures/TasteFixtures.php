<?php

namespace App\DataFixtures;

use App\Entity\Taste;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TasteFixtures extends Fixture
{
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
        foreach (self::TASTES as $tasteName) {
            $taste = new Taste();
            $taste->setNameTaste($tasteName);
            $manager->persist($taste);
            $this->addReference('taste_' . $tasteName, $taste);
        }
        $manager->flush();
    }
}
