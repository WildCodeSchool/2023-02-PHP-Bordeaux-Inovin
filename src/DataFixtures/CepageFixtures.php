<?php

namespace App\DataFixtures;

use App\Entity\Cepage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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

    public function load(ObjectManager $manager): void
    {
        foreach (self::CEPAGES as $cepageName) {
            $cepage = new Cepage();
            $cepage->setNameCepage($cepageName);
            $manager->persist($cepage);
            $this->addReference('cepage_' . $cepageName, $cepage);
        }
        $manager->flush();
    }
}
