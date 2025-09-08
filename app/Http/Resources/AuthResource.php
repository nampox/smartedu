<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AuthResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'user' => new UserResource($this->resource),
            'token' => $this->when($this->token, $this->token),
            'expires_at' => $this->when($this->expires_at, $this->expires_at),
        ];
    }
}
