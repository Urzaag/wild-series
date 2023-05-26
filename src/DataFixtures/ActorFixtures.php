<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use App\Repository\ProgramRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        //$programRepository = new ProgramRepository();

        for ($actorIterator = 1; $actorIterator <= 10; $actorIterator++) {
            $actor = new Actor();

            $actor->setName($faker->name());
            for ($i = 0; $i < 3; $i++)
            {
                $actor->addProgram($this->getReference('program_' . $faker->/*unique()->*/numberBetween(1, 5)));
            }

            $manager->persist($actor);
            $this->addReference('actor_' . $actorIterator, $actor);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
