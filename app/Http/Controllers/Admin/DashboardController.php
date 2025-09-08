<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CacheService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userService;

    protected $cacheService;

    public function __construct(UserService $userService, CacheService $cacheService)
    {
        $this->userService = $userService;
        $this->cacheService = $cacheService;
    }

    /**
     * Hiển thị dashboard admin
     */
    public function index()
    {
        // Lấy thống kê từ cache hoặc tạo mới
        $userStats = $this->cacheService->cacheUserStats();
        $logStats = $this->cacheService->cacheLogStats();
        $appConfig = $this->cacheService->cacheAppConfig();

        return view('admin.dashboard', compact('userStats', 'logStats', 'appConfig'));
    }

    /**
     * Quản lý users
     */
    public function users(Request $request)
    {
        $search = $request->get('search');

        if ($search) {
            $users = $this->userService->searchUsers($search);
        } else {
            $users = $this->userService->getAllUsers();
        }

        $userStats = $this->userService->getUserStats();

        return view('admin.users', compact('users', 'userStats', 'search'));
    }

    /**
     * Xem chi tiết user
     */
    public function showUser($id)
    {
        $user = $this->userService->getUserById($id);

        if (! $user) {
            return redirect()->route('admin.users')
                ->with('error', 'Không tìm thấy user.');
        }

        return view('admin.user-detail', compact('user'));
    }

    /**
     * Thay đổi role user
     */
    public function changeUserRole(Request $request, $id)
    {
        $user = $this->userService->getUserById($id);

        if (! $user) {
            return redirect()->back()
                ->with('error', 'Không tìm thấy user.');
        }

        $newRole = $request->input('role');

        if ($this->userService->changeUserRole($user, $newRole)) {
            // Clear cache sau khi thay đổi
            $this->cacheService->clearUserStatsCache();

            return redirect()->back()
                ->with('success', 'Thay đổi role thành công.');
        }

        return redirect()->back()
            ->with('error', 'Có lỗi xảy ra khi thay đổi role.');
    }

    /**
     * Xóa user
     */
    public function deleteUser($id)
    {
        $user = $this->userService->getUserById($id);

        if (! $user) {
            return redirect()->back()
                ->with('error', 'Không tìm thấy user.');
        }

        if ($this->userService->deleteUser($user)) {
            // Clear cache sau khi xóa
            $this->cacheService->clearUserStatsCache();

            return redirect()->route('admin.users')
                ->with('success', 'Xóa user thành công.');
        }

        return redirect()->back()
            ->with('error', 'Có lỗi xảy ra khi xóa user.');
    }

    /**
     * Refresh cache
     */
    public function refreshCache()
    {
        $this->cacheService->clearAllCaches();

        return redirect()->back()
            ->with('success', 'Đã làm mới cache thành công.');
    }
}
