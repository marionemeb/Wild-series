<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 1000; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $this->addReference("category_" . $i, $category);

            $actor = new Actor();
            $slug = new Slugify();
            $actor->setName($faker->firstName);
            $slug = $slug->generate($actor->getName());
            $actor->setSlug($slug);
            $manager->persist($actor);
        }

        for ($i = 0; $i <= 1000; $i++) {
            $program = new Program();
            $slug = new Slugify();
            $program->setTitle($faker->sentence(4, true));
            $program->setSummary($faker->text(100));
            $program->setCategory($this->getReference("category_" . rand(0, 1000)));
            $program->setPoster($faker->imageUrl);
            $slug = $slug->generate($program->getTitle());
            $program->setSlug($slug);
            $manager->persist($program);
        }

        $manager->flush();

    }
}
