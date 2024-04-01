<?php

namespace App\Dto\Auth;

use App\Dto\User\UserDto;

class LoggedUserDto
{
    public function __construct(
        public UserDto $user,
        public string $token
    )
    {
    }
}
