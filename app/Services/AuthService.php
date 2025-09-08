<?php

namespace App\Services;

use App\DTOs\AuthDTO;
use App\DTOs\UserDTO;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Đăng ký user mới
     */
    public function register(RegisterRequest $request): User
    {
        $authDTO = AuthDTO::fromRegisterRequest($request);
        $userData = $authDTO->getUserData();
        $userData['password'] = Hash::make($userData['password']);
        $userData['roles'] = config('roles.user');

        $user = $this->userRepository->create($userData);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        return $user;
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(LoginRequest $request): bool
    {
        $authDTO = AuthDTO::fromLoginRequest($request);
        $credentials = $authDTO->getCredentials();

        if (Auth::attempt($credentials, $authDTO->remember)) {
            // Chỉ regenerate session nếu không phải API request
            if (!$request->is('api/*')) {
                $request->session()->regenerate();
            }

            return true;
        }

        return false;
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Kiểm tra user có phải admin không
     */
    public function isAdmin(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && $user->isAdmin();
    }

    /**
     * Lấy thông tin user hiện tại
     */
    public function getCurrentUser(): ?User
    {
        return Auth::user();
    }

    /**
     * Lấy thông tin user hiện tại dưới dạng DTO
     */
    public function getCurrentUserDTO(): ?UserDTO
    {
        $user = Auth::user();
        return $user ? UserDTO::fromModel($user) : null;
    }

    /**
     * Tìm user theo email
     */
    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Tìm user theo ID
     */
    public function findUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
