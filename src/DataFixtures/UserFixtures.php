<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture //implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($userIterator = 0; $userIterator < 10; $userIterator++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setBirthday($faker->dateTimeBetween('-50 years', '-20 years'))
                ->setZipcode(24120)
                ->setPhoneNumber($faker->phoneNumber());
                /*->addColor($this->getReference('color_' . $faker->numberBetween(1, 3)))
                ->addArome($this->getReference('arome_' . $faker->numberBetween(1, 8)))
                ->addRegion($this->getReference('region_' . $faker->numberBetween(1, 10)));*/


            if ($userIterator === 9) {
                $user->setEmail('admin@inovin.fr');
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
            $this->addReference('user_' . $userIterator, $user);
        }

        $manager->flush();
    }

    /*public function getDependencies()
    {
        return [
            ::class,
        ];
    }*/
}
