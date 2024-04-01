<?php

namespace App\Services\NotificationSenders;

use App\Contracts\Notification\NotificationMessageDataClassContract;
use App\Contracts\Notification\NotificationSenderContract;
use Illuminate\Support\Facades\Validator;

class PhoneNotificationSender implements NotificationSenderContract
{

    public function send(string $recipient, NotificationMessageDataClassContract $messageDataClass): void
    {
        $this->validatePhone($recipient);

        // TODO: Необходимо реализовать отправку SMS через сервисы на подобии SmsAero
    }

    private function validatePhone($recipient):void
    {
        Validator::validate([
            'recipient' => $recipient
        ], [
            'recipient' => ['required', 'integer', 'min:10', 'max:13'],
        ]);
    }
}
