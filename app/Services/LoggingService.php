<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LoggingService
{
    /**
     * Log user activity
     */
    public function logUserActivity(string $action, array $data = []): void
    {
        $logData = array_merge([
            'action' => $action,
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data);

        Log::channel('user_activity')->info('User Activity', $logData);
    }

    /**
     * Log system events
     */
    public function logSystemEvent(string $event, array $data = []): void
    {
        $logData = array_merge([
            'event' => $event,
            'timestamp' => now()->toISOString(),
            'server' => gethostname(),
        ], $data);

        Log::channel('system')->info('System Event', $logData);
    }

    /**
     * Log security events
     */
    public function logSecurityEvent(string $event, array $data = []): void
    {
        $logData = array_merge([
            'event' => $event,
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data);

        Log::channel('security')->warning('Security Event', $logData);
    }

    /**
     * Log API requests
     */
    public function logApiRequest(string $method, string $url, array $data = []): void
    {
        $logData = array_merge([
            'method' => $method,
            'url' => $url,
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data);

        Log::channel('api')->info('API Request', $logData);
    }

    /**
     * Get log statistics
     */
    public function getLogStats(): array
    {
        $logPath = storage_path('logs');
        $stats = [];

        $channels = ['user_activity', 'system', 'security', 'api'];

        foreach ($channels as $channel) {
            $logFile = $logPath . '/laravel-' . $channel . '.log';
            
            if (file_exists($logFile)) {
                $stats[$channel] = [
                    'file_size' => filesize($logFile),
                    'last_modified' => filemtime($logFile),
                    'line_count' => $this->countLines($logFile),
                ];
            } else {
                $stats[$channel] = [
                    'file_size' => 0,
                    'last_modified' => null,
                    'line_count' => 0,
                ];
            }
        }

        return $stats;
    }

    /**
     * Clean old logs
     */
    public function cleanOldLogs(int $days = 30): int
    {
        $logPath = storage_path('logs');
        $cutoffDate = Carbon::now()->subDays($days);
        $deletedCount = 0;

        $files = glob($logPath . '/*.log');

        foreach ($files as $file) {
            if (filemtime($file) < $cutoffDate->timestamp) {
                if (unlink($file)) {
                    $deletedCount++;
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Export logs
     */
    public function exportLogs(string $channel, Carbon $from, Carbon $to): string
    {
        $logFile = storage_path('logs/laravel-' . $channel . '.log');
        
        if (!file_exists($logFile)) {
            throw new \Exception('Log file not found');
        }

        $exportPath = storage_path('app/exports/logs-' . $channel . '-' . now()->format('Y-m-d-H-i-s') . '.txt');
        
        // Create export directory if it doesn't exist
        if (!is_dir(dirname($exportPath))) {
            mkdir(dirname($exportPath), 0755, true);
        }

        // Read and filter logs
        $lines = file($logFile, FILE_IGNORE_NEW_LINES);
        $filteredLines = [];

        foreach ($lines as $line) {
            if (preg_match('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matches)) {
                $logDate = Carbon::createFromFormat('Y-m-d H:i:s', $matches[1]);
                
                if ($logDate->between($from, $to)) {
                    $filteredLines[] = $line;
                }
            }
        }

        file_put_contents($exportPath, implode("\n", $filteredLines));

        return $exportPath;
    }

    /**
     * Count lines in file
     */
    protected function countLines(string $file): int
    {
        $count = 0;
        $handle = fopen($file, 'r');

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $count++;
            }
            fclose($handle);
        }

        return $count;
    }
}
