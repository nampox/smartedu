<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * Lấy class model
     */
    abstract protected function getModel(): string;

    /**
     * Tìm model theo ID
     */
    public function findById(int $id): ?Model
    {
        return $this->model::find($id);
    }

    /**
     * Tìm model theo ID hoặc throw exception
     */
    public function findOrFail(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    /**
     * Lấy tất cả records
     */
    public function all(): Collection
    {
        return $this->model::all();
    }

    /**
     * Tạo model mới
     */
    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    /**
     * Cập nhật model
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Xóa model
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Tìm kiếm theo điều kiện
     */
    public function findBy(array $criteria): Collection
    {
        $query = $this->model::query();

        // Thêm các điều kiện where
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get();
    }

    /**
     * Tìm kiếm theo điều kiện (1 record)
     */
    public function findOneBy(array $criteria): ?Model
    {
        $query = $this->model::query();

        // Thêm các điều kiện where
        foreach ($criteria as $field => $value) {
            $query->where($field, $value);
        }

        return $query->first();
    }

    /**
     * Đếm số records
     */
    public function count(): int
    {
        return $this->model::count();
    }

    /**
     * Pagination
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model::paginate($perPage);
    }
}
