<?php

namespace App\Console\Commands;

use App\Services\LoggingService;
use Illuminate\Console\Command;

class LogCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:cleanup {--days=30 : Number of days to keep logs}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old log files';

    /**
     * Execute the console command.
     */
    public function handle(LoggingService $loggingService): int
    {
        $days = (int) $this->option('days');
        
        $this->info("Cleaning up logs older than {$days} days...");
        
        $deletedCount = $loggingService->cleanOldLogs($days);
        
        $this->info("Deleted {$deletedCount} log files.");
        
        return Command::SUCCESS;
    }
}