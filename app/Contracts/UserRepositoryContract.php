<?php

namespace App\Contracts;

use App\Dto\Auth\RegisterRequestDto;
use App\Dto\User\UserDto;

interface UserRepositoryContract
{
    public function checkExistUserByEmail(string $email):bool;
    public function createUser(RegisterRequestDto $registerRequestDto):UserDto;

    public function confirmEmail(string $userId): void;
}
