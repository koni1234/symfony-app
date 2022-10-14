<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $password = $this->passwordHasher->hashPassword($user, '123');
        $user->setPassword($password);
        $user->setEmail('andreozzi.nicolo@gmail.com');
        $user->setRoles([Roles::ROLE_USER->value]);

        $manager->persist($user);
        $manager->flush();
    }
}
