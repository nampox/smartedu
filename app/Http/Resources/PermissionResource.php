<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            
            // Computed fields
            'roles_count' => $this->whenCounted('roles'),
            'users_count' => $this->whenCounted('users'),
            'display_name' => $this->getDisplayName(),
            'description' => $this->getDescription(),
            'category' => $this->getCategory(),
        ];
    }

    /**
     * Get display name for permission
     */
    private function getDisplayName(): string
    {
        $names = [
            'view-users' => 'Xem danh sách người dùng',
            'create-users' => 'Tạo người dùng mới',
            'edit-users' => 'Chỉnh sửa người dùng',
            'delete-users' => 'Xóa người dùng',
            'upload-files' => 'Tải lên tệp tin',
            'view-files' => 'Xem tệp tin',
            'delete-files' => 'Xóa tệp tin',
            'upload-media' => 'Tải lên media',
            'view-media' => 'Xem media',
            'delete-media' => 'Xóa media',
            'download-media' => 'Tải xuống media',
            'manage-media' => 'Quản lý media',
            'view-admin-dashboard' => 'Xem bảng điều khiển admin',
            'manage-roles' => 'Quản lý vai trò',
            'manage-permissions' => 'Quản lý quyền hạn',
            'create-content' => 'Tạo nội dung',
            'edit-content' => 'Chỉnh sửa nội dung',
            'delete-content' => 'Xóa nội dung',
            'publish-content' => 'Xuất bản nội dung',
        ];
        
        return $names[$this->name] ?? ucfirst(str_replace('-', ' ', $this->name));
    }

    /**
     * Get description for permission
     */
    private function getDescription(): string
    {
        $descriptions = [
            'view-users' => 'Cho phép xem danh sách tất cả người dùng trong hệ thống',
            'create-users' => 'Cho phép tạo tài khoản người dùng mới',
            'edit-users' => 'Cho phép chỉnh sửa thông tin người dùng',
            'delete-users' => 'Cho phép xóa tài khoản người dùng',
            'upload-files' => 'Cho phép tải lên tệp tin lên hệ thống',
            'view-files' => 'Cho phép xem danh sách tệp tin',
            'delete-files' => 'Cho phép xóa tệp tin khỏi hệ thống',
            'upload-media' => 'Cho phép tải lên media (hình ảnh, video, tài liệu)',
            'view-media' => 'Cho phép xem danh sách media',
            'delete-media' => 'Cho phép xóa media khỏi hệ thống',
            'download-media' => 'Cho phép tải xuống media',
            'manage-media' => 'Cho phép quản lý toàn bộ media trong hệ thống',
            'view-admin-dashboard' => 'Cho phép truy cập bảng điều khiển quản trị',
            'manage-roles' => 'Cho phép quản lý vai trò và phân quyền',
            'manage-permissions' => 'Cho phép quản lý quyền hạn trong hệ thống',
            'create-content' => 'Cho phép tạo nội dung mới',
            'edit-content' => 'Cho phép chỉnh sửa nội dung',
            'delete-content' => 'Cho phép xóa nội dung',
            'publish-content' => 'Cho phép xuất bản nội dung',
        ];
        
        return $descriptions[$this->name] ?? 'Không có mô tả';
    }

    /**
     * Get category for permission
     */
    private function getCategory(): string
    {
        $categories = [
            'view-users' => 'users',
            'create-users' => 'users',
            'edit-users' => 'users',
            'delete-users' => 'users',
            'upload-files' => 'files',
            'view-files' => 'files',
            'delete-files' => 'files',
            'upload-media' => 'media',
            'view-media' => 'media',
            'delete-media' => 'media',
            'download-media' => 'media',
            'manage-media' => 'media',
            'view-admin-dashboard' => 'admin',
            'manage-roles' => 'admin',
            'manage-permissions' => 'admin',
            'create-content' => 'content',
            'edit-content' => 'content',
            'delete-content' => 'content',
            'publish-content' => 'content',
        ];
        
        return $categories[$this->name] ?? 'other';
    }
}