<?php

namespace App\Contracts\User;

use App\Dto\Auth\RegisterRequestDto;
use App\Dto\User\UserDto;

interface UserRepositoryContract
{
    public function checkExistUserByEmail(string $email):bool;
    public function createUser(RegisterRequestDto $registerRequestDto):UserDto;

    public function confirmEmail(int $userId): void;

    public function getUserById(int $userId): UserDto;
}
