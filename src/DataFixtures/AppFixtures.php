<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->text(250));
            $wish->setDescription($faker->text(350));
            $wish->setAuthor($faker->text(50));
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime('now'));
            $wish->setDateUpdated(new \DateTime(''));
            $manager->persist($wish);

            $manager->flush();
        }
    }
}
