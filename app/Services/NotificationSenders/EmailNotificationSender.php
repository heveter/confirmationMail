<?php

namespace App\Services\NotificationSenders;

use App\Contracts\Notification\NotificationMessageDataClassContract;
use App\Contracts\Notification\NotificationSenderContract;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailNotificationSender implements NotificationSenderContract
{

    public function send(string $recipient, NotificationMessageDataClassContract $messageDataClass): void
    {
        $this->validateEmail($recipient);

        Mail::to($recipient)->send(new NotificationMail($messageDataClass));
    }

    private function validateEmail($recipient):void
    {
        Validator::validate([
            'recipient' => $recipient
        ], [
            'recipient' => ['required', 'string', 'email'],
        ]);
    }
}
