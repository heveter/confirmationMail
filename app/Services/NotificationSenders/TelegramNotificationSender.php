<?php

namespace App\Services\NotificationSenders;

use App\Contracts\Notification\NotificationMessageDataClassContract;
use App\Contracts\Notification\NotificationSenderContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TelegramNotificationSender implements NotificationSenderContract
{

    private readonly string $token;
    public function __construct()
    {
        $this->token = config('telegram.token');
    }

    public function send(string $recipient, NotificationMessageDataClassContract $messageDataClass): void
    {
        $this->validateTelegramChatId($recipient);

        // TODO: Добавить проверку на оошибку, когда бользователь не добавил бота.
        Http::post("https://api.telegram.org/bot$this->token/sendMessage", [
            'text' => '',
            'chat_id' => $recipient
        ]);
    }

    private function validateTelegramChatId($recipient):void
    {
        Validator::validate([
            'recipient' => $recipient
        ], [
            'recipient' => ['required', 'integer'],
        ]);
    }
}
