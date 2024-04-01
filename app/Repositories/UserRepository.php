<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Dto\Auth\RegisterRequestDto;
use App\Dto\User\UserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryContract
{

    public function createUser(RegisterRequestDto $registerRequestDto): UserDto
    {
        $user=User::query()->create([
            'name'=>$registerRequestDto->name,
            'email'=>mb_strtolower($registerRequestDto->email),
            'password'=>Hash::make($registerRequestDto->password),
        ]);
        return new UserDto(
            userId: $user->id,
            name: $user->name,
            email: $user->email,
            phone: $user->phone,
            telegramChatId: $user->telegramChatId
        );
    }

    public function checkExistUserByEmail(string $email): bool
    {
        return User::query()->where('email', mb_strtolower($email))->exists();
    }

    public function confirmEmail(string $userId): void
    {
        User::query()->where('id', $userId)->update(['email_verified_at' => now()]);
    }
}
