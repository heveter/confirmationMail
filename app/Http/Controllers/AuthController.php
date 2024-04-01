<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceContract;
use App\Dto\Auth\RegisterRequestDto;
use App\Http\Requests\ConfirmationEmailRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ConfirmationEmailResource;
use App\Http\Resources\RegisterResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthServiceContract $authService
    )
    {
    }

    public function register(RegisterRequest $request)
    {
        $registerRequestDto = new RegisterRequestDto(
            name: $request->get('name'),
            email: $request->get('email'),
            password: $request->get('password'),
        );

        $loggedUser = $this->authService->register($registerRequestDto);

        return response()->json(new RegisterResource($loggedUser));
    }

    public function confirmationEmail(ConfirmationEmailRequest $request)
    {
        $userId = Auth::id();

        $this->authService->confirmationEmail($userId, $request->get('code'));

        return response()->json(['status' => true]);
    }
}
