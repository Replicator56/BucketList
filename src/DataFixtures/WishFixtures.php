<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;


class WishFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->sentence(4));
            $wish->setDescription($faker->paragraph(3));
            $wish->setAuthor($faker->name());
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $wish->setDateUpdated(new \DateTime());
            $wish->setImage(null);

            // Choisir une catégorie aléatoire
            $randomIndex = rand(0, 4);
            $category = $this->getReference('category_' . $randomIndex, Category::class);
            $wish->setCategory($category);

            $manager->persist($wish);
        }

        $manager->flush();
    }

    // Déclare la dépendance à CategoryFixtures pour garantir l’ordre de chargement
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }
}
