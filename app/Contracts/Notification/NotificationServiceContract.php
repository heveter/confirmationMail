<?php

namespace App\Contracts\Notification;

use App\Dto\Notification\SendNotificationDto;

interface NotificationServiceContract
{
    public function sendNotification(SendNotificationDto $sendNotification): void;
}
