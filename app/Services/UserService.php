<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Lấy danh sách tất cả users
     */
    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    /**
     * Lấy thông tin user theo ID
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Lấy thông tin user theo ID hoặc throw exception
     */
    public function getUserByIdOrFail(int $id): User
    {
        $user = $this->userRepository->findById($id);
        
        if (!$user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        return $user;
    }

    /**
     * Tạo user mới
     */
    public function createUser(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['roles'] = $data['roles'] ?? config('roles.user');

        return $this->userRepository->create($data);
    }

    /**
     * Cập nhật thông tin user
     */
    public function updateUser(User $user, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }

    /**
     * Xóa user
     */
    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    /**
     * Thay đổi role của user
     */
    public function changeUserRole(User $user, int $role): bool
    {
        return $this->userRepository->update($user, ['roles' => $role]);
    }

    /**
     * Tìm kiếm users
     */
    public function searchUsers(string $keyword)
    {
        return $this->userRepository->search($keyword);
    }

    /**
     * Lấy thống kê users
     */
    public function getUserStats(): array
    {
        return $this->userRepository->getStats();
    }

    /**
     * Lấy user dưới dạng DTO
     */
    public function getUserDTO(int $id): ?UserDTO
    {
        $user = $this->userRepository->findById($id);
        return $user ? UserDTO::fromModel($user) : null;
    }

    /**
     * Lấy tất cả users dưới dạng DTOs
     */
    public function getAllUsersDTO(): array
    {
        $users = $this->userRepository->all();
        return $users->map(fn($user) => UserDTO::fromModel($user))->toArray();
    }

    /**
     * Kiểm tra email đã tồn tại chưa
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        return $this->userRepository->emailExists($email, $excludeId);
    }

    /**
     * Kiểm tra phone đã tồn tại chưa
     */
    public function phoneExists(string $phone, ?int $excludeId = null): bool
    {
        return $this->userRepository->phoneExists($phone, $excludeId);
    }
}
