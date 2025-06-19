<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WishFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($i = 0; $i < 20; $i++){
            $wish = new Wish();
            $wish -> setTitle($faker->text(50));
            $wish -> setDescription($faker->text(100));
            $wish -> setAuthor($faker->name(50));
            $wish -> setIsPublished($faker->boolean(50));
            $wish -> setDateCreated($faker->dateTimeBetween('-1 year', 'now'));
            $wish -> setDateUpdated(new \DateTime());

            $manager->persist($wish);
        }

        $manager->flush();
    }
}
