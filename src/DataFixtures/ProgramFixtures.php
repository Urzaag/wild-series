<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        1 => [
            'title' => 'Le seigneur des anneaux',
            'synopsis' => 'La meilleure saga de tous les temps. Pas de débat.',
            'category' => 'Fantastique',
        ],
        2 => [
            'title' => 'Lost',
            'synopsis' => 'Après s\'être écrasé sur une île déserte, un groupe de survivants tente de percer les mystères de l\'île',
            'category' => 'Aventure'
        ],
        3 => [
            'title' => 'Les Fils de l\'Homme',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Action'
        ],
        4 => [
            'title' => 'Whiplash',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Horreur'
        ],
        5 => [
            'title' => 'Birdman',
            'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel.',
            'category' => 'Horreur'
        ],
    ];

    public const USERS = [
        'contributor',
        'admin'
    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $programs)
        {
            $program = new Program();

            $program->setOwner($this->getReference('user_' . self::USERS[array_rand(self::USERS, 1)]));
            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCategory($this->getReference('category_' . $programs['category']));
            $program->setSlug($this->slugger->slug($program->getTitle()));

            $manager->persist($program);
            $this->addReference('program_' . $key, $program);


        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
