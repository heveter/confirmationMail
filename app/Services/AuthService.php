<?php

namespace App\Services;

use App\Contracts\AuthServiceContract;
use App\Contracts\Notification\NotificationServiceContract;
use App\Contracts\UserRepositoryContract;
use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\RegisterRequestDto;
use App\Dto\Notification\Messages\ConfirmationMessageDataClass;
use App\Dto\Notification\SendNotificationDto;
use App\Enums\NotificationTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceContract
{
    private const CONFIRM_CODE_CACHE_KEY = 'confirm_code_';

    public function __construct(
        private readonly UserRepositoryContract $userRepository,
        private readonly NotificationServiceContract $notificationService
    )
    {

    }

    public function register(RegisterRequestDto $registerRequestDto): LoggedUserDto
    {
        if ($this->userRepository->checkExistUserByEmail($registerRequestDto->email)) {
            throw ValidationException::withMessages(['email' => 'Пользователь с таким email уже зарегистрирован']);
        }
        $user = $this->userRepository->createUser($registerRequestDto);
        $token = Auth::loginUsingId($user->userId)->createToken('authToken')->plainTextToken;

        $confirmCode = $this->createConfirmCode($user->userId);

        $this->notificationService->sendNotification(new SendNotificationDto(
            notificationType: NotificationTypeEnum::EMAIL,
            recipient: $user->email,
            messageDataClass: new ConfirmationMessageDataClass(
                code: $confirmCode,
                subject: 'Подтверждение почты',
            )
        ));

        return new LoggedUserDto(
            $user,
            $token
        );
    }

    private function createConfirmCode(string $userId): string
    {
        $code = random_int(100000, 999999);
        Cache::set(
            self::CONFIRM_CODE_CACHE_KEY . $userId,
            $code,
            60 * 5
        );
        return $code;
    }

    private function getConfirmCode(string $userId): ?string
    {
        return Cache::get(self::CONFIRM_CODE_CACHE_KEY . $userId);
    }

    public function confirmationEmail(string $userId, string $code): void
    {
        $confirmCode = $this->getConfirmCode($userId);

        if (is_null($confirmCode)) {
            ValidationException::withMessages(['code' =>'Время жизни кода истекло']);
        }

        if ($confirmCode !== $code) {
            ValidationException::withMessages(['code' => 'Неверный код']);
        }

        $this->userRepository->confirmEmail($userId);
    }
}
