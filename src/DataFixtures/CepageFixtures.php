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
    public const CEPAGES_BLANC = [
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
        'Trebbiano blanc'];

    public const CEPAGES_ROUGE =   [ 'Cabernet-Sauvignon',
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
    public const COLOR_BLANC = 'Blanc';
    public const COLOR_ROUGE = 'Rouge';

    public function load(ObjectManager $manager): void
    {
        foreach (self::CEPAGES_ROUGE as $cepageName) {
            $cepage = new Cepage();
            $cepage->setNameCepage($cepageName);
            $manager->persist($cepage);
            $this->addReference('cepage_' . $cepageName, $cepage);
        }
        foreach (self::CEPAGES_BLANC as $cepageName) {
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
        for ($i = 0; $i < 20; $i++) {
            $wine = new Wine();
            $wine->setProducer('Château ' . $faker->lastName);
            $wine->setProductionYear($faker->year());
            $cepageName = $this->getReference('cepage_' . self::CEPAGES_ROUGE[array_rand(self::CEPAGES_ROUGE)]);
            $wine->setCepage($cepageName);
            $color = $this->getReference('color_' . self::COLOR_ROUGE);
            $wine->setColor($color);



            $wine = new Wine();
            $wine->setProducer('Château ' . $faker->lastName);
            $wine->setProductionYear($faker->year());
            $cepageName = $this->getReference('cepage_' . self::CEPAGES_BLANC[array_rand(self::CEPAGES_BLANC)]);
            $wine->setCepage($cepageName);
            $color = $this->getReference('color_' . self::COLOR_BLANC);
            $wine->setColor($color);
            $manager->persist($wine);

            $this->addReference('wine_' . $i, $wine);
        }
        $manager->flush();

    }

}
