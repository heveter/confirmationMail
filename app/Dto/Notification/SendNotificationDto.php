<?php

namespace App\Dto\Notification;

use App\Contracts\Notification\NotificationMessageDataClassContract;
use App\Enums\NotificationTypeEnum;

class SendNotificationDto
{
    public function __construct(
        public NotificationTypeEnum $notificationType,
        public string $recipient,
        public NotificationMessageDataClassContract $messageDataClass
    )
    {
    }
}
