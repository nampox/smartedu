<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Hiển thị danh sách log với các bộ lọc
     */
    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        $date = $request->get('date', Carbon::now()->format('Y-m-d'));
        $level = $request->get('level', '');
        $search = $request->get('search', '');

        $logs = [];
        $availableDates = [];

        // Lấy danh sách các ngày có log file
        $logFiles = File::glob(storage_path('logs/laravel-*.log'));
        foreach ($logFiles as $file) {
            if (preg_match('/laravel-(\d{4}-\d{2}-\d{2})\.log/', $file, $matches)) {
                $availableDates[] = $matches[1];
            }
        }

        // Kiểm tra file log hiện tại
        if (File::exists($logPath)) {
            $availableDates[] = Carbon::now()->format('Y-m-d');
        }

        $availableDates = array_unique($availableDates);
        rsort($availableDates);

        // Đọc nội dung log cho ngày được chọn
        $selectedLogFile = storage_path("logs/laravel-{$date}.log");
        if (File::exists($selectedLogFile)) {
            $logContent = File::get($selectedLogFile);
        } elseif (File::exists($logPath) && $date === Carbon::now()->format('Y-m-d')) {
            $logContent = File::get($logPath);
        } else {
            $logContent = '';
        }

        // Phân tích các entry log
        if (! empty($logContent)) {
            $lines = explode("\n", $logContent);
            $currentEntry = '';

            foreach ($lines as $line) {
                // Kiểm tra xem dòng có phải là đầu của một log entry không
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $line, $matches)) {
                    // Xử lý entry trước đó nếu có
                    if (! empty($currentEntry)) {
                        $parsedLog = $this->parseLogEntry($currentEntry);
                        if ($parsedLog && $this->shouldIncludeLog($parsedLog, $level, $search)) {
                            $logs[] = $parsedLog;
                        }
                    }
                    $currentEntry = $line;
                } else {
                    // Nối dòng vào entry hiện tại (cho stack trace, context, etc.)
                    $currentEntry .= "\n".$line;
                }
            }

            // Xử lý entry cuối cùng
            if (! empty($currentEntry)) {
                $parsedLog = $this->parseLogEntry($currentEntry);
                if ($parsedLog && $this->shouldIncludeLog($parsedLog, $level, $search)) {
                    $logs[] = $parsedLog;
                }
            }
        }

        // Sắp xếp log theo thời gian (mới nhất trước)
        usort($logs, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return view('logs.index', compact('logs', 'availableDates', 'date', 'level', 'search'));
    }

    /**
     * Kiểm tra log có nên được hiển thị không dựa trên bộ lọc
     */
    private function shouldIncludeLog($log, $level, $search)
    {
        // Lọc theo level (ERROR, WARNING, INFO, etc.)
        if (! empty($level) && $log['level'] !== $level) {
            return false;
        }

        // Lọc theo từ khóa tìm kiếm
        if (! empty($search)) {
            $searchLower = strtolower($search);
            $messageLower = strtolower($log['message']);
            $channelLower = strtolower($log['channel']);

            // Tìm kiếm trong message hoặc channel
            if (strpos($messageLower, $searchLower) === false &&
                strpos($channelLower, $searchLower) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Phân tích một log entry thành các thành phần
     */
    private function parseLogEntry($entry)
    {
        // Sử dụng regex để tách các thành phần của log entry
        if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.+)$/', $entry, $matches)) {
            $timestamp = $matches[1];
            $level = strtoupper($matches[2]);
            $channel = $matches[3];
            $message = $matches[4];

            // Lấy các dòng bổ sung (stack trace, context, etc.)
            $lines = explode("\n", $entry);
            $additionalLines = array_slice($lines, 1);

            // Phân tích JSON context nếu có
            $context = null;
            $stackTrace = [];

            foreach ($additionalLines as $line) {
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }

                // Kiểm tra JSON context (exception, file info, etc.)
                if (strpos($line, '{"exception"') !== false || strpos($line, '{"file"') !== false) {
                    $context = $this->parseJsonContext($line);
                }

                // Kiểm tra stack trace (bắt đầu bằng #)
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
                'level_class' => $this->getLevelClass($level),
            ];
        }

        return null;
    }

    /**
     * Phân tích JSON context từ log entry
     */
    private function parseJsonContext($jsonString)
    {
        try {
            $data = json_decode($jsonString, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        } catch (Exception $e) {
            // Bỏ qua lỗi phân tích JSON
        }

        return null;
    }

    /**
     * Lấy CSS class tương ứng với level của log
     */
    private function getLevelClass($level)
    {
        switch ($level) {
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
