<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

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
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::EPISODES as $episodes)
        {
            $episode = new Episode();

            $episode->setNumber($episodes['number']);
            $episode->setTitle($episodes['title']);
            $episode->setSynopsis($episodes['synopsis']);
            $episode->setSeason($this->getReference('season_' . $episodes['season']));

            $manager->persist($episode);
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
