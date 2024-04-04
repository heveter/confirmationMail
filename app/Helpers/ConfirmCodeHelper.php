<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class ConfirmCodeHelper
{
    private const CONFIRM_CODE_CACHE_KEY = 'confirm_code_';

    public static function createConfirmCode(int $userId): string
    {
        return Cache::remember(
            key: self::CONFIRM_CODE_CACHE_KEY . $userId,
            ttl: 60 * 5,
            callback: function () {
                // TODO: Для тестирования фронта
                return 123456;
            }
        );
    }

    public static function getConfirmCode(int $userId): ?string
    {
        return Cache::get(self::CONFIRM_CODE_CACHE_KEY . $userId);
    }
}
