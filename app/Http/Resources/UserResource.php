<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User Resource",
 *     description="User resource representation",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Nguyễn Văn A"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="phone", type="string", example="0123456789"),
 *     @OA\Property(
 *         property="role",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=0),
 *         @OA\Property(property="name", type="string", example="User")
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T00:00:00.000000Z")
 * )
 */
class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            
            // Relationships
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            
            // Computed fields
            'roles_count' => $this->whenCounted('roles'),
            'permissions_count' => $this->whenCounted('permissions'),
            'media_count' => $this->whenCounted('media'),
            
            // Role information
            'role_name' => $this->getRoleName(),
            'role_description' => $this->getRoleDescription(),
            'is_admin' => $this->isAdmin(),
            'is_user' => $this->isUser(),
            
            // Media information
            'avatar_url' => $this->avatar_url,
            'original_avatar_url' => $this->original_avatar_url,
            
            // Permissions
            'can_upload_media' => $this->can('upload-media'),
            'can_view_media' => $this->can('view-media'),
            'can_manage_users' => $this->can('manage-roles'),
        ];
    }
}
