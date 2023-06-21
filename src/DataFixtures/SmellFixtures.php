<?php

namespace App\DataFixtures;

use App\Entity\Smell;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SmellFixtures extends Fixture
{
    public const SMELLS = [
        'Fleurs',
        'Bois',
        'Fruits',
        'Epices',
        'Animal',
        'Défauts',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::SMELLS as $smellName) {
            $smell = new Smell();
            $smell->setNameSmell($smellName);
            $manager->persist($smell);
            $this->addReference('smell_' . $smellName, $smell);
        }
        $manager->flush();
    }
}
