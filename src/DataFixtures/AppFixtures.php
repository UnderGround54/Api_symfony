<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < 50; $p++) {
            $post = new Post;
            $post->setTitle($faker->catchPhrase)
                ->setContent($faker->paragraphs(5, true))
                ->setCreatedAt($faker->dateTimeBetween('+1 week', '+1 month'));

            $manager->persist($post);

            for ($c = 0; $c < mt_rand(3, 5); $c++) {
                $comment = new Comment;
                $comment->setContent($faker->paragraphs(mt_rand(1, 3), true))
                    ->setUsername($faker->userName)
                    ->setPost($post);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
