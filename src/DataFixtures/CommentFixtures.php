<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->paragraph());
            $manager->persist($comment);
            $this->addReference('comment_' . $i, $comment);
        }

        $manager->flush();
    }
}
