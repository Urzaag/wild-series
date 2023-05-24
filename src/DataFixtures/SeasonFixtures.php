<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS = [
      0 => [
          'number' => 1,
          'year' => 2015,
          'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan elementum libero sed semper. Aenean.',
          'program' => 'Le seigneur des anneaux'
      ],
        2 => [
            'number' => 1,
            'year' => 2016,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan elementum libero sed semper. Aenean.',
            'program' => 'Lost'
        ],
        3 => [
            'number' => 2,
            'year' => 2017,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan elementum libero sed semper. Aenean.',
            'program' => 'Lost'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($programIterator = 1; $programIterator <= 5; $programIterator++)
        {
            for ($seasonIterator = 1; $seasonIterator <= 5; $seasonIterator++)
            {
                $season = new Season();
                //$season->setNumber($seasons['number']);
                $season->setNumber($seasonIterator);
                //$season->setYear($seasons['year']);
                $season->setYear($faker->year());
                //$season->setDescription($seasons['description']);
                $season->setDescription($faker->paragraphs(3, true));

                $season->setProgram($this->getReference('program_' . $programIterator));
                $manager->persist($season);
                $this->addReference('program_' . $programIterator . '_season_' . $seasonIterator, $season);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
