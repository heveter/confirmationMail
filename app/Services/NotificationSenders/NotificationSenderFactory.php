<?php

namespace App\Services\NotificationSenders;

use App\Contracts\Notification\NotificationSenderContract;
use App\Enums\NotificationTypeEnum;
use Illuminate\Notifications\NotificationSender;

class NotificationSenderFactory
{
    public static function getSender(NotificationTypeEnum $notificationType): NotificationSenderContract
    {
        return match ($notificationType) {
            NotificationTypeEnum::EMAIL => app(EmailNotificationSender::class),
            NotificationTypeEnum::PHONE => app(PhoneNotificationSender::class),
            NotificationTypeEnum::TELEGRAM => app(TelegramNotificationSender::class),

        };
    }
}
