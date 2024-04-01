<?php

namespace App\Dto\Auth;

class RegisterRequestDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    )
    {

    }
}
