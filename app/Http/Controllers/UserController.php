<?php

namespace App\Http\Controllers;

use App\Contracts\User\UserServiceContract;
use App\Dto\User\ChangeNameDto;
use App\Enums\NotificationTypeEnum;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Resources\NotificationMethodResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    )
    {
    }

    public function getAvailableNotificationMethods()
    {
        $methods = $this->userService->getAvailableNotificationMethods(Auth::id());

        return response()->json(NotificationMethodResource::collection($methods));
    }

    public function sendConfirmCode(Request $request)
    {
        $this->userService->sendConfirmCode(
            userId: Auth::id(),
            type: $request->enum('type', NotificationTypeEnum::class)
        );
        return response()->json(['status' => true]);
    }
}
