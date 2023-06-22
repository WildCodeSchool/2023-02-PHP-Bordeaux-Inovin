<?php

namespace App\DataFixtures;

use App\Entity\Workshop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WorkshopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create('fr_FR');

        for ($workshopIterator = 0; $workshopIterator < 10; $workshopIterator++) {
            $workshop = new Workshop();

            $workshop
                ->setNameWorkshop($faker->sentence(3))
                ->setDateWorkshop($faker->dateTimeThisYear('+8 months'))
                ->setPlaceWorkshop($faker->address());
            $manager->persist($workshop);
            $manager->flush();

            $codeWorkshop = strval($workshop->getId() . $workshop->getDateWorkshop()->format('md'));
            $workshop->setCodeWorkshop($codeWorkshop);

            $manager->persist($workshop);
            $this->addReference('workshop_' . $workshopIterator, $workshop);
        }
        $manager->flush();
    }
}
