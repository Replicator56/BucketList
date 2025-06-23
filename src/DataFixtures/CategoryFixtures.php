<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $names = [
            'Travel and Adventure',
            'Sport',
            'Entertainment',
            'Human Relations',
            'Others'
        ];

        foreach ($names as $index => $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);

            // Enregistrer une référence accessible par d'autres fixtures
            $this->addReference('category_' . $index, $category);
        }

        $manager->flush();
    }
}
