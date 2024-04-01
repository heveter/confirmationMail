<?php

namespace App\Http\Resources;

use App\Dto\Auth\LoggedUserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property LoggedUserDto $resource */
class RegisterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id'=>$this->resource->user->userId,
            'token'=>$this->resource->token
        ];
    }
}
