<?php

namespace App\Services;

use App\Contracts\Notification\NotificationServiceContract;
use App\Contracts\User\UserRepositoryContract;
use App\Contracts\User\UserServiceContract;
use App\Dto\Notification\Messages\ConfirmationMessageDataClass;
use App\Dto\Notification\SendNotificationDto;
use App\Enums\NotificationTypeEnum;
use App\Helpers\ConfirmCodeHelper;

class UserService implements UserServiceContract
{
    public function __construct(
        private readonly UserRepositoryContract      $userRepository,
        private readonly NotificationServiceContract $notificationService,
    )
    {
    }

    public function sendConfirmCode(int $userId, NotificationTypeEnum $type): void
    {
        $user = $this->userRepository->getUserById($userId);

        $recipient = match ($type) {
            NotificationTypeEnum::EMAIL => $user->email,
            NotificationTypeEnum::PHONE => $user->phone,
            NotificationTypeEnum::TELEGRAM => $user->telegramChatId,
        };
        if (is_null($recipient)) {
            throw new \Exception('Невозможно отправить код');
        }

        $confirmCode = ConfirmCodeHelper::createConfirmCode($userId);

        $this->notificationService->sendNotification(new SendNotificationDto(
            notificationType: $type,
            recipient: $recipient,
            messageDataClass: new ConfirmationMessageDataClass(
                code: $confirmCode,
                subject: 'Код подтверждения'
            )
        ));
    }

    public function getAvailableNotificationMethods(int $userId): array
    {
        $user = $this->userRepository->getUserById($userId);

        $availableNotificationTypes = [NotificationTypeEnum::EMAIL];

        if (!is_null($user->phone)) {
            $availableNotificationTypes[] = NotificationTypeEnum::PHONE;
        }

        if (!is_null($user->telegramChatId)) {
            $availableNotificationTypes[] = NotificationTypeEnum::TELEGRAM;
        }

        return $availableNotificationTypes;
    }
}
