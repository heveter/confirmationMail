<?php

namespace App\Contracts\User;

use App\Enums\NotificationTypeEnum;

interface UserServiceContract
{
    public function getAvailableNotificationMethods(int $userId): array;

    public function sendConfirmCode(int $userId, NotificationTypeEnum $type): void;
}
