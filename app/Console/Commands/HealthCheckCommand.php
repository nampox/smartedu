<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'health:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform system health check';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Performing system health check...');
        
        $checks = [
            'Database' => $this->checkDatabase(),
            'Cache' => $this->checkCache(),
            'Storage' => $this->checkStorage(),
            'Queue' => $this->checkQueue(),
            'Memory' => $this->checkMemory(),
            'Disk Space' => $this->checkDiskSpace(),
        ];

        $allHealthy = true;

        foreach ($checks as $component => $status) {
            if ($status['healthy']) {
                $this->line("<fg=green>✓</> {$component}: {$status['message']}");
            } else {
                $this->line("<fg=red>✗</> {$component}: {$status['message']}");
                $allHealthy = false;
            }
        }

        if ($allHealthy) {
            $this->info('All systems are healthy!');
            return Command::SUCCESS;
        } else {
            $this->error('Some systems are not healthy!');
            return Command::FAILURE;
        }
    }

    /**
     * Check database connection
     */
    protected function checkDatabase(): array
    {
        try {
            DB::connection()->getPdo();
            return [
                'healthy' => true,
                'message' => 'Connected successfully'
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check cache system
     */
    protected function checkCache(): array
    {
        try {
            $key = 'health_check_' . time();
            Cache::put($key, 'test', 60);
            $value = Cache::get($key);
            Cache::forget($key);
            
            if ($value === 'test') {
                return [
                    'healthy' => true,
                    'message' => 'Working correctly'
                ];
            } else {
                return [
                    'healthy' => false,
                    'message' => 'Cache test failed'
                ];
            }
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Cache error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check storage system
     */
    protected function checkStorage(): array
    {
        try {
            $testFile = 'health_check_' . time() . '.txt';
            Storage::disk('public')->put($testFile, 'test');
            $content = Storage::disk('public')->get($testFile);
            Storage::disk('public')->delete($testFile);
            
            if ($content === 'test') {
                return [
                    'healthy' => true,
                    'message' => 'Working correctly'
                ];
            } else {
                return [
                    'healthy' => false,
                    'message' => 'Storage test failed'
                ];
            }
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Storage error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check queue system
     */
    protected function checkQueue(): array
    {
        try {
            // Check if queue table exists and is accessible
            $count = DB::table('jobs')->count();
            return [
                'healthy' => true,
                'message' => "Queue table accessible ({$count} jobs)"
            ];
        } catch (\Exception $e) {
            return [
                'healthy' => false,
                'message' => 'Queue error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check memory usage
     */
    protected function checkMemory(): array
    {
        $memoryUsage = memory_get_usage(true);
        $memoryLimit = ini_get('memory_limit');
        
        $memoryUsageMB = round($memoryUsage / 1024 / 1024, 2);
        
        if ($memoryLimit === '-1') {
            $memoryLimitMB = 'unlimited';
        } else {
            $memoryLimitMB = $memoryLimit;
        }
        
        return [
            'healthy' => true,
            'message' => "Usage: {$memoryUsageMB}MB / {$memoryLimitMB}"
        ];
    }

    /**
     * Check disk space
     */
    protected function checkDiskSpace(): array
    {
        $freeBytes = disk_free_space(storage_path());
        $totalBytes = disk_total_space(storage_path());
        
        $freeGB = round($freeBytes / 1024 / 1024 / 1024, 2);
        $totalGB = round($totalBytes / 1024 / 1024 / 1024, 2);
        $usedPercent = round((($totalBytes - $freeBytes) / $totalBytes) * 100, 2);
        
        if ($usedPercent > 90) {
            return [
                'healthy' => false,
                'message' => "Disk space low: {$usedPercent}% used ({$freeGB}GB free)"
            ];
        }
        
        return [
            'healthy' => true,
            'message' => "Disk space OK: {$usedPercent}% used ({$freeGB}GB free)"
        ];
    }
}