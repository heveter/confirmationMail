<?php

namespace App\Contracts\Notification;

interface NotificationMessageDataClassContract
{
    public function mailerTemplate():string;
    public function mailerSubject():string;
    public function phoneSMSText():string;
    public function telegramMessageText():string;
}
