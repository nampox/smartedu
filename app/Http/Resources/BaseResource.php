<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }

    /**
     * Get additional data that should be returned with the resource array.
     */
    public function with($request): array
    {
        return [
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => '1.0.0',
            ],
        ];
    }

    /**
     * Get the pagination links for the resource.
     */
    public function paginationInformation($request, $paginated, $default): array
    {
        return [
            'data' => $default['data'],
            'links' => $default['links'],
            'meta' => array_merge($default['meta'], [
                'timestamp' => now()->toISOString(),
                'version' => '1.0.0',
            ]),
        ];
    }
}
