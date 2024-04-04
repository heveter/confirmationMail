<?php

namespace App\Http\Resources;

use App\Enums\NotificationTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property NotificationTypeEnum $resource */
class NotificationMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource->value,
            'name' => $this->resource->name
        ];
    }
}
