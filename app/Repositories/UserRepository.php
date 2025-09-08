<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected function getModel(): string
    {
        return User::class;
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model::where('email', $email)->first();
    }

    /**
     * Tìm user theo số điện thoại
     */
    public function findByPhone(string $phone): ?User
    {
        return $this->model::where('phone', $phone)->first();
    }

    /**
     * Tìm kiếm users theo tên hoặc email
     */
    public function search(string $query): Collection
    {
        return $this->model::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        })->get();
    }

    /**
     * Lấy users theo role
     */
    public function getByRole(int $role): Collection
    {
        return $this->model::where('roles', $role)->get();
    }

    /**
     * Lấy thống kê users
     */
    public function getStats(): array
    {
        return [
            'total' => $this->count(),
            'users' => $this->model::where('roles', config('roles.user'))->count(),
            'admins' => $this->model::where('roles', config('roles.admin'))->count(),
            'this_month' => $this->model::whereMonth('created_at', now()->month)->count(),
            'this_week' => $this->model::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];
    }

    /**
     * Lấy users mới nhất
     */
    public function getLatest(int $limit = 10): Collection
    {
        return $this->model::latest()->limit($limit)->get();
    }

    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = $this->model::where('email', $email);
        
        // Loại trừ user hiện tại khi cập nhật
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Kiểm tra số điện thoại đã tồn tại chưa
     */
    public function phoneExists(string $phone, ?int $excludeId = null): bool
    {
        $query = $this->model::where('phone', $phone);
        
        // Loại trừ user hiện tại khi cập nhật
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
