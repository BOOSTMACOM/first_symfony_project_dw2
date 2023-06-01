<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [];
        for($i=1;$i<=10;$i++)
        {
            $category = new Category();
            $category->setName($faker->word());

            $manager->persist($category);
            $categories[] = $category;
        }
        $manager->flush();

        for($i=1;$i<=500;$i++)
        {
            $post = new Post();
            $post->setTitle($faker->realText(100));
            $post->setContent($faker->realTextBetween(500, 5000));
            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setCategory($categories[rand(0,9)]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
