<?php

namespace App\Services;

use App\Contracts\Notification\NotificationServiceContract;
use App\Dto\Notification\SendNotificationDto;
use App\Exceptions\SendNotificationErrorException;
use App\Services\NotificationSenders\NotificationSenderFactory;

class NotificationService implements NotificationServiceContract
{
    /**
     * @throws SendNotificationErrorException
     */
    public function sendNotification(SendNotificationDto $sendNotification): void
    {
        $sender=NotificationSenderFactory::getSender($sendNotification->notificationType);
        try {
            $sender->send(
                recipient: $sendNotification->recipient,
                messageDataClass: $sendNotification->messageDataClass,
            );
        }
       catch (\Throwable $exception){
            throw new SendNotificationErrorException(previous: $exception);
       }
    }


}
