<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Output\LoginOutput;
use App\Entity\User;

class LoginManager
{
    public function __construct()
    {
    }

    public function setJWT(User $user): LoginOutput
    {
        return new LoginOutput(
            $user->getUserIdentifier(),
            'token'
        );
    }
}
