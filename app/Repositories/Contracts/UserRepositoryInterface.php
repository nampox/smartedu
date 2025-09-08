<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Tìm user theo email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Tìm user theo phone
     */
    public function findByPhone(string $phone): ?User;

    /**
     * Tìm kiếm users theo tên hoặc email
     */
    public function search(string $query): Collection;

    /**
     * Lấy users theo role
     */
    public function getByRole(int $role): Collection;

    /**
     * Lấy thống kê users
     */
    public function getStats(): array;

    /**
     * Lấy users mới nhất
     */
    public function getLatest(int $limit = 10): Collection;

    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function emailExists(string $email, ?int $excludeId = null): bool;

    /**
     * Kiểm tra phone đã tồn tại chưa
     */
    public function phoneExists(string $phone, ?int $excludeId = null): bool;
}
