<?php

namespace App\DataFixtures;

use App\Entity\Arome;
use App\Entity\Color;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GoutFixtures extends Fixture
{
    public const AROME = ['Florale', 'Végétale', 'Fruité', 'Epicé', 'Sucré',
        'Animal', 'Chimique', 'Boisée'];
    public const COLOR = ['Blanc', 'Rouge', 'Rosé'];

    public const REGION = ['Val de loire', 'Sud-ouest', 'Bourgogne', 'Provence-Corse', 'Charentais',
        'Jura-Savoie', 'Languedoc-Rousillon', 'Bordeaux', 'Rhone', 'Alsace-Loraine'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::AROME as $aromeName) {
            $arome = new Arome();
            $arome->setNameArome($aromeName);
            $manager->persist($arome);
            $this->addReference('arome_' . $aromeName, $arome);
        }
        $manager->flush();

        foreach (self::REGION as $regionName) {
            $region = new Region();
            $region->setNameRegion($regionName);
            $manager->persist($region);
            $this->addReference('region_' . $regionName, $region);
        }
        $manager->flush();
    }
}
