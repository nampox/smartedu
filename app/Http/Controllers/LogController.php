<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        $date = $request->get('date', Carbon::now()->format('Y-m-d'));
        $level = $request->get('level', '');
        $search = $request->get('search', '');
        
        $logs = [];
        $availableDates = [];
        
        // Get available dates from log files
        $logFiles = File::glob(storage_path('logs/laravel-*.log'));
        foreach ($logFiles as $file) {
            if (preg_match('/laravel-(\d{4}-\d{2}-\d{2})\.log/', $file, $matches)) {
                $availableDates[] = $matches[1];
            }
        }
        
        // Also check current laravel.log
        if (File::exists($logPath)) {
            $availableDates[] = Carbon::now()->format('Y-m-d');
        }
        
        $availableDates = array_unique($availableDates);
        rsort($availableDates);
        
        // Read logs for selected date
        $selectedLogFile = storage_path("logs/laravel-{$date}.log");
        if (File::exists($selectedLogFile)) {
            $logContent = File::get($selectedLogFile);
        } elseif (File::exists($logPath) && $date === Carbon::now()->format('Y-m-d')) {
            $logContent = File::get($logPath);
        } else {
            $logContent = '';
        }
        
        // Parse log entries
        if (!empty($logContent)) {
            $lines = explode("\n", $logContent);
            $currentEntry = '';
            
            foreach ($lines as $line) {
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $line, $matches)) {
                    if (!empty($currentEntry)) {
                        $parsedLog = $this->parseLogEntry($currentEntry);
                        if ($parsedLog && $this->shouldIncludeLog($parsedLog, $level, $search)) {
                            $logs[] = $parsedLog;
                        }
                    }
                    $currentEntry = $line;
                } else {
                    $currentEntry .= "\n" . $line;
                }
            }
            
            if (!empty($currentEntry)) {
                $parsedLog = $this->parseLogEntry($currentEntry);
                if ($parsedLog && $this->shouldIncludeLog($parsedLog, $level, $search)) {
                    $logs[] = $parsedLog;
                }
            }
        }
        
        // Sort logs by timestamp (newest first)
        usort($logs, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        return view('logs.index', compact('logs', 'availableDates', 'date', 'level', 'search'));
    }
    
    private function shouldIncludeLog($log, $level, $search)
    {
        // Filter by level
        if (!empty($level) && $log['level'] !== $level) {
            return false;
        }
        
        // Filter by search term
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $messageLower = strtolower($log['message']);
            $channelLower = strtolower($log['channel']);
            
            if (strpos($messageLower, $searchLower) === false && 
                strpos($channelLower, $searchLower) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    private function parseLogEntry($entry)
    {
        if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $entry, $matches)) {
            $timestamp = $matches[1];
            $level = strtoupper($matches[2]);
            $channel = $matches[3];
            $message = $matches[4];
            
            // Get additional lines
            $lines = explode("\n", $entry);
            $additionalLines = array_slice($lines, 1);
            
            // Parse JSON context if exists
            $context = null;
            $stackTrace = [];
            
            foreach ($additionalLines as $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                // Check for JSON context
                if (strpos($line, '{"exception"') !== false || strpos($line, '{"file"') !== false) {
                    $context = $this->parseJsonContext($line);
                }
                
                // Check for stack trace
                if (strpos($line, '#') === 0) {
                    $stackTrace[] = $line;
                }
            }
            
            return [
                'timestamp' => $timestamp,
                'level' => $level,
                'channel' => $channel,
                'message' => $message,
                'additional_lines' => $additionalLines,
                'context' => $context,
                'stack_trace' => $stackTrace,
                'level_class' => $this->getLevelClass($level)
            ];
        }
        
        return null;
    }
    
    private function parseJsonContext($jsonString)
    {
        try {
            $data = json_decode($jsonString, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        } catch (Exception $e) {
            // Ignore JSON parsing errors
        }
        
        return null;
    }
    
    private function getLevelClass($level)
    {
        switch($level) {
            case 'ERROR':
            case 'CRITICAL':
            case 'ALERT':
            case 'EMERGENCY':
                return 'danger';
            case 'WARNING':
                return 'warning';
            case 'NOTICE':
            case 'INFO':
                return 'info';
            case 'DEBUG':
                return 'secondary';
            default:
                return 'primary';
        }
    }
}
