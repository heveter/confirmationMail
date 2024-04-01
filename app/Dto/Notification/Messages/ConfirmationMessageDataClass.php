<?php

namespace App\Dto\Notification\Messages;

use App\Contracts\Notification\NotificationMessageDataClassContract;

class ConfirmationMessageDataClass implements NotificationMessageDataClassContract
{

    public function __construct(
        public string $code,
        public string $subject
    )
    {

    }

    public function mailerTemplate(): string
    {
        return 'emails.confirmation';
    }

    public function phoneSMSText(): string
    {
        return 'Код: '.$this->code;
    }

    public function telegramMessageText(): string
    {
        return 'Код: '.$this->code;
    }

    public function mailerSubject(): string
    {
        return $this->subject;
    }
}
