<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            
            // Computed fields
            'permissions_count' => $this->whenCounted('permissions'),
            'users_count' => $this->whenCounted('users'),
            'display_name' => $this->getDisplayName(),
            'description' => $this->getDescription(),
        ];
    }

    /**
     * Get display name for role
     */
    private function getDisplayName(): string
    {
        $names = [
            'admin' => 'Quản trị viên',
            'user' => 'Người dùng',
            'moderator' => 'Điều hành viên',
            'teacher' => 'Giảng viên',
            'student' => 'Học viên',
        ];
        
        return $names[$this->name] ?? ucfirst($this->name);
    }

    /**
     * Get description for role
     */
    private function getDescription(): string
    {
        $descriptions = [
            'admin' => 'Có toàn quyền quản lý hệ thống',
            'user' => 'Người dùng thông thường với quyền hạn cơ bản',
            'moderator' => 'Có quyền quản lý nội dung và người dùng',
            'teacher' => 'Giảng viên có quyền tạo và quản lý khóa học',
            'student' => 'Học viên có quyền tham gia khóa học',
        ];
        
        return $descriptions[$this->name] ?? 'Không có mô tả';
    }
}