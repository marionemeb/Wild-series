<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    const ACTORS = [
        'Bill Istvan Günther Skarsgård',
        'Logan Thompson',
        'Owen William Teague',
        'Jackson Robert Scott',
        'Stephen Bogaert',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $actor = new Actor();
            $slug = new Slugify();
            $actor->setName($faker->name);
            $slug = $slug->generate($actor->getName());
            $actor->setSlug($slug);
            $actor->addProgram($this->getReference('program_0', $actor));
            $this->addReference('actor_' . $i, $actor);
            $manager->persist($actor);
        }

        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $slug = new Slugify();
            $actor->setName($actorName);
            $slug = $slug->generate($actor->getName());
            $actor->setSlug($slug);
            $actor->addProgram($this->getReference('program_0', $actor));
            $this->addReference('actor' . $key, $actor);
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
