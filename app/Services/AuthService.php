<?php

namespace App\Services;

use App\Contracts\AuthServiceContract;
use App\Contracts\Notification\NotificationServiceContract;
use App\Contracts\User\UserRepositoryContract;
use App\Dto\Auth\LoggedUserDto;
use App\Dto\Auth\RegisterRequestDto;
use App\Dto\Notification\Messages\ConfirmationMessageDataClass;
use App\Dto\Notification\SendNotificationDto;
use App\Enums\NotificationTypeEnum;
use App\Helpers\ConfirmCodeHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceContract
{
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

        $confirmCode = ConfirmCodeHelper::createConfirmCode($user->userId);

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

    public function confirmationEmail(int $userId, string $code): void
    {
        $confirmCode = ConfirmCodeHelper::getConfirmCode($userId);

        if (is_null($confirmCode)) {
            ValidationException::withMessages(['code' =>'Время жизни кода истекло']);
        }

        if ($confirmCode !== $code) {
            ValidationException::withMessages(['code' => 'Неверный код']);
        }

        $this->userRepository->confirmEmail($userId);
    }
}
