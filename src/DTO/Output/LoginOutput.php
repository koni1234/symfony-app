<?php

declare(strict_types=1);

namespace App\DTO\Output;

final class LoginOutput
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
