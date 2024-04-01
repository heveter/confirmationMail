<?php

namespace App\Contracts\Notification;

interface NotificationSenderContract
{
    public function send(string $recipient, NotificationMessageDataClassContract $messageDataClass):void;
}
