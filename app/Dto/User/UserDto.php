<?php

namespace App\Dto\User;

class UserDto
{
    public function __construct(
        public string  $userId,
        public string  $name,
        public string  $email,
        public ?string $phone,
        public ?string $telegramChatId,
    )
    {
    }
}
