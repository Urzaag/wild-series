<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODES = [
        0 => [
            'number' => 1,
            'title' => 'les fixtures du schnaps',
            'synopsis' => 'les fixtures de ses morts',
            'season' => 1,
        ],
        1 => [
            'number' => 2,
            'title' => 'les fixtures de tous les dangers',
            'synopsis' => 'les fixtures de l\'enfer',
            'season' => 1,
        ],
        2 => [
            'number' => 1,
            'title' => 'les fixtures de l\'emmerde',
            'synopsis' => 'les fixtures qui saoulent',
            'season' => 2
        ]
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for ($programIterator = 1; $programIterator <= 5; $programIterator++)
        {
            for ($seasonIterator = 1; $seasonIterator <= 5; $seasonIterator++)
            {
                for ($episodeIterator = 1; $episodeIterator <= 10; $episodeIterator++)
                {
                    $episode = new Episode();

                    $episode->setNumber($episodeIterator);
                    $episode->setTitle($faker->word());
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setSeason($this->getReference('program_' . $programIterator . '_season_' . $seasonIterator));
                    $episode->setDuration($faker->randomNumber(2));
                    $episode->setSlug($this->slugger->slug($episode->getTitle()));
                    $episode->setCreatedAt(new \DateTimeImmutable('now'));
                    $manager->persist($episode);
                }

            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
