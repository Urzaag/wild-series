<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
        // TODO: set the right values to the te right fields, add reference to the right program and create one for episodes to rely
        // $product = new Product();
        // $manager->persist($product);

        foreach (self::SEASONS as $seasons)
        {
            $season = new Season();
            $season->setNumber($seasons['number']);
            $season->setYear($seasons['year']);
            $season->setDescription($seasons['description']);
            $season->setProgram($this->getReference('program_' . $seasons['program']));

            $manager->persist($season);
            $this->addReference('season_' . $seasons['number'], $season);
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
