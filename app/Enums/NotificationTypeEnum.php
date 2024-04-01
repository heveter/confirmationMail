<?php

namespace App\Enums;

enum NotificationTypeEnum:string
{
    case EMAIL="email";
    case PHONE="phone";
    case TELEGRAM="telegram";
}
