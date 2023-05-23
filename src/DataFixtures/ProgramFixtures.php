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
        foreach (self::PROGRAMS as $key => $programs)
        {
            $program = new Program();
            foreach ($programs as $key => $programDetails)
            {
                /*if ($key == 'title') {
                    $program->setTitle('test1');
                } elseif ($key == 'synopsis') {
                    $program->setSynopsis('test2');
                } elseif ($key == 'category') {
                    $program->setCategory('test3');
                }*/
                switch ($key) {
                    case 'title':
                        $program->setTitle($programs['title']);
                        break;
                    case 'synopsis':
                        $program->setSynopsis($programs['synopsis']);
                        break;
                    case 'category':
                        $program->setCategory($this->getReference('category_' . $programs['category']));
                        break;
                }
                $manager->persist($program);
            }
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
