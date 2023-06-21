<?php

namespace App\DataFixtures;

use App\Entity\Cepage;
use App\Entity\Color;
use App\Entity\Wine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CepageFixtures extends Fixture
{
    public const CEPAGES = [
        'Chardonnay',
        'Sauvignon blanc',
        'Sémillon',
        'Chenin blanc',
        'Riesling',
        'Gewurztraminer',
        'Pinot blanc',
        'Pinot gris',
        'Viognier',
        'Muscat blanc',
        'Sylvaner',
        'Malvasia',
        'Trebbiano blanc',
        'Cabernet-Sauvignon',
        'Pinot noir',
        'Merlot',
        'Syrah (Shiraz)',
        'Cabernet franc',
        'Gamay',
        'Grenache',
        'Cinsault',
        'Carignan',
        'Barbera',
        'Sangiovese',
        'Zinfandel',
        'Tempranillo'
    ];
    public const COLOR = ['Blanc', 'Rouge', 'Rosé'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CEPAGES as $cepageName) {
            $cepage = new Cepage();
            $cepage->setNameCepage($cepageName);
            $manager->persist($cepage);
            $this->addReference('cepage_' . $cepageName, $cepage);
        }
         $manager->flush();

        foreach (self::COLOR as $colorName) {
            $color = new Color();
            $color->setNameColor($colorName);
            $manager->persist($color);
            $this->addReference('color_' . $colorName, $color);
        }

        $manager->flush();


        $faker = Factory::create();
        for ($i = 1; $i < 50; $i++) {
            $wine = new Wine();
            $wine->setProducer('Château ' . $faker->lastName);
            $wine->setProductionYear($faker->year());
            $cepageName = $this->getReference('cepage_' . self::CEPAGES[array_rand(self::CEPAGES)]);
            $wine->setCepage($cepageName);
            $color = $this->getReference('color_' . self::COLOR[array_rand(self::COLOR)]);
            $wine->setColor($color);
            $manager->persist($wine);
        }

        $manager->flush();
    }

}
