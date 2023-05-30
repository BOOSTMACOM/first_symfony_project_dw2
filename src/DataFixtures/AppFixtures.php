<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=1;$i<=500;$i++)
        {
            $post = new Post();
            $post->setTitle($faker->realText(100));
            $post->setContent($faker->realTextBetween(500, 5000));
            $post->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($post);
        }

        $manager->flush();
    }
}
