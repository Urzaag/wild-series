<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const PASSWORDS = [
        'contributor',
        'admin'
    ];

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                self::PASSWORDS[$i]
            );
            $user->setPassword($hashedPassword);
            switch ($i) {
                case 0:
                    $user->setRoles(['ROLE_CONTRIBUTOR']);
                    $user->setEmail('contributor@site.com');
                    break;
                case 1:
                    $user->setRoles(['ROLE_ADMIN']);
                    $user->setEmail('admin@site.com');
                    break;
            }
            $manager->persist($user);
        }


        $manager->flush();
    }
    /*
    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'contributorpassword'
        );

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }*/
}
