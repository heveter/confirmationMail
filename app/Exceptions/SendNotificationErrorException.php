<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SendNotificationErrorException extends Exception
{

    public function render(Request $request)
    {
        return response()->json([
            'error'=>'send_notification',
            'message'=>'не удалось отправить уведомление'
        ]);
    }
}
