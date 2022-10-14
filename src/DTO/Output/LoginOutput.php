<?php

declare(strict_types=1);

namespace App\DTO\Output;

final class LoginOutput
{
    public function __construct(public string $email, public string $token)
    {
    }
}
