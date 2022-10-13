<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Input\LoginInput;
use App\DTO\Output\LoginOutput;
use App\Exception\InvalidCredentialException;
use App\Repository\UserRepository;
use App\Service\PasswordEncrypt;

class LoginManager
{
    public function __construct(private UserRepository $repository, private PasswordEncrypt $passwordEncrypt)
    {
    }

    public function login(LoginInput $login): LoginOutput
    {
        $user = $this->repository->findOneBy([
            'email' => $login->email,
            'password' => $this->passwordEncrypt->encrypt($login->password),
        ]);

        if (null === $user) {
            throw new InvalidCredentialException();
        }

        return new LoginOutput($user->getEmail());
    }
}
