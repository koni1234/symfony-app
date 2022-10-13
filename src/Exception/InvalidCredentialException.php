<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InvalidCredentialException extends BadRequestHttpException
{
    public function __construct()
    {
        parent::__construct('Invalid credentials');
    }
}
