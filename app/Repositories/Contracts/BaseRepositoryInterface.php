<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Tìm model theo ID
     */
    public function findById(int $id): ?Model;

    /**
     * Tìm model theo ID hoặc throw exception
     */
    public function findOrFail(int $id): Model;

    /**
     * Lấy tất cả records
     */
    public function all(): Collection;

    /**
     * Tạo model mới
     */
    public function create(array $data): Model;

    /**
     * Cập nhật model
     */
    public function update(Model $model, array $data): bool;

    /**
     * Xóa model
     */
    public function delete(Model $model): bool;

    /**
     * Tìm kiếm theo điều kiện
     */
    public function findBy(array $criteria): Collection;

    /**
     * Tìm kiếm theo điều kiện (1 record)
     */
    public function findOneBy(array $criteria): ?Model;

    /**
     * Đếm số records
     */
    public function count(): int;

    /**
     * Pagination
     */
    public function paginate(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
