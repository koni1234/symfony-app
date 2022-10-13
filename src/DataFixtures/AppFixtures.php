<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\PasswordEncrypt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(private PasswordEncrypt $passwordEncrypt)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('andreozzi.nicolo@gmail.com');
        $user->setPassword($this->passwordEncrypt->encrypt('123'));

        $manager->persist($user);
        $manager->flush();
    }
}
