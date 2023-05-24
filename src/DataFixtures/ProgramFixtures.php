<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        0 => [
            'title' => 'Le seigneur des anneaux',
            'synopsis' => 'La meilleure saga de tous les temps. Pas de débat.',
            'category' => 'Fantastique',
        ],
        1 => [
            'title' => 'Lost',
            'synopsis' => 'Après s\'être écrasé sur une île déserte, un groupe de survivants tente de percer les mystères de l\'île',
            'category' => 'Aventure'
        ],
        2 => [
            'title' => 'Les Fils de l\'Homme',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Action'
        ],
        3 => [
            'title' => 'Whiplash',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Horreur'
        ],
        4 => [
            'title' => 'Birdman',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Horreur'
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $programs)
        {
            $program = new Program();

            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCategory($this->getReference('category_' . $programs['category']));

            $manager->persist($program);
            $this->addReference('program_' . $programs['title'], $program);


        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
