<?php

namespace App\Contracts;

use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\RegisterRequestDto;

interface AuthServiceContract
{
    public function register(RegisterRequestDto $registerRequestDto): LoggedUserDto;

    public function confirmationEmail(int $userId, string $code): void;
}
