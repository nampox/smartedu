<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache key prefixes
     */
    const USER_STATS_KEY = 'user_stats';

    const LOG_STATS_KEY = 'log_stats';

    const APP_CONFIG_KEY = 'app_config';

    /**
     * Cache thống kê người dùng
     */
    public function cacheUserStats(): array
    {
        return Cache::remember(self::USER_STATS_KEY, 3600, function () {
            return [
                'total_users' => \App\Models\User::count(),
                'admin_users' => \App\Models\User::role('admin')->count(),
                'regular_users' => \App\Models\User::role('user')->count(),
                'new_users_today' => \App\Models\User::whereDate('created_at', today())->count(),
                'new_users_this_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
            ];
        });
    }

    /**
     * Lấy thống kê người dùng từ cache
     */
    public function getUserStats(): array
    {
        return Cache::get(self::USER_STATS_KEY, []);
    }

    /**
     * Xóa cache thống kê người dùng
     */
    public function clearUserStatsCache(): void
    {
        Cache::forget(self::USER_STATS_KEY);
    }

    /**
     * Cache cấu hình ứng dụng
     */
    public function cacheAppConfig(): array
    {
        return Cache::remember(self::APP_CONFIG_KEY, 7200, function () {
            return [
                'app_name' => config('app.name'),
                'app_version' => '1.0.0',
                'roles' => config('roles'),
                'features' => [
                    'log_viewer' => true,
                    'user_management' => true,
                    'api_access' => true,
                ],
            ];
        });
    }

    /**
     * Lấy cấu hình ứng dụng từ cache
     */
    public function getAppConfig(): array
    {
        return Cache::get(self::APP_CONFIG_KEY, []);
    }

    /**
     * Cache thống kê log
     */
    public function cacheLogStats(): array
    {
        return Cache::remember(self::LOG_STATS_KEY, 1800, function () {
            $logPath = storage_path('logs/laravel.log');
            $stats = [
                'total_logs' => 0,
                'error_logs' => 0,
                'warning_logs' => 0,
                'info_logs' => 0,
                'debug_logs' => 0,
            ];

            if (file_exists($logPath)) {
                $content = file_get_contents($logPath);
                $lines = explode("\n", $content);

                // Phân tích từng dòng log để đếm theo level
                foreach ($lines as $line) {
                    if (preg_match('/^\[.*\] (\w+)\./', $line, $matches)) {
                        $stats['total_logs']++;
                        $level = strtoupper($matches[1]);

                        // Phân loại log theo level
                        switch ($level) {
                            case 'ERROR':
                            case 'CRITICAL':
                            case 'ALERT':
                            case 'EMERGENCY':
                                $stats['error_logs']++;
                                break;
                            case 'WARNING':
                                $stats['warning_logs']++;
                                break;
                            case 'INFO':
                            case 'NOTICE':
                                $stats['info_logs']++;
                                break;
                            case 'DEBUG':
                                $stats['debug_logs']++;
                                break;
                        }
                    }
                }
            }

            return $stats;
        });
    }

    /**
     * Lấy thống kê log từ cache
     */
    public function getLogStats(): array
    {
        return Cache::get(self::LOG_STATS_KEY, []);
    }

    /**
     * Xóa tất cả cache
     */
    public function clearAllCaches(): void
    {
        Cache::flush();
    }

    /**
     * Xóa cache theo key cụ thể
     */
    public function clearCache(string $key): void
    {
        Cache::forget($key);
    }

    /**
     * Cache với thời gian sống tùy chỉnh
     */
    public function cache(string $key, $value, int $ttl = 3600): void
    {
        Cache::put($key, $value, $ttl);
    }

    /**
     * Lấy giá trị từ cache
     */
    public function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * Kiểm tra cache key có tồn tại không
     */
    public function has(string $key): bool
    {
        return Cache::has($key);
    }
}
