<?php
declare(strict_types=1);

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;

final class Login {
    #[Assert\NotBlank()]
    public string $email;

    #[Assert\NotBlank()]
    public string $password;
}