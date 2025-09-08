<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class MediaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:manage {action} {--user=} {--collection=} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quản lý media files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'list':
                $this->listMedia();
                break;
            case 'cleanup':
                $this->cleanupMedia();
                break;
            case 'stats':
                $this->showStats();
                break;
            case 'delete':
                $this->deleteMedia();
                break;
            case 'regenerate':
                $this->regenerateConversions();
                break;
            default:
                $this->error('Action không hợp lệ. Các action có sẵn: list, cleanup, stats, delete, regenerate');
        }
    }

    private function listMedia()
    {
        $userId = $this->option('user');
        $collection = $this->option('collection');

        $query = Media::query();

        if ($userId) {
            $query->where('model_type', User::class)
                  ->where('model_id', $userId);
        }

        if ($collection) {
            $query->where('collection_name', $collection);
        }

        $mediaItems = $query->with('model')->get();

        if ($mediaItems->isEmpty()) {
            $this->info('Không tìm thấy media nào.');
            return;
        }

        $this->info('Danh sách Media:');
        $this->line('');

        foreach ($mediaItems as $media) {
            $this->line("ID: {$media->id}");
            $this->line("Name: {$media->name}");
            $this->line("File: {$media->file_name}");
            $this->line("Collection: {$media->collection_name}");
            $this->line("Size: " . $this->formatBytes($media->size));
            $this->line("MIME: {$media->mime_type}");
            $this->line("Model: " . ($media->model ? $media->model->name : 'N/A'));
            $this->line("Created: {$media->created_at}");
            $this->line("URL: {$media->getUrl()}");
            $this->line('---');
        }
    }

    private function cleanupMedia()
    {
        $this->info('Đang dọn dẹp media...');

        // Tìm media không có model
        $orphanedMedia = Media::whereDoesntHave('model')->get();

        if ($orphanedMedia->isEmpty()) {
            $this->info('Không có media orphaned nào.');
            return;
        }

        $this->info("Tìm thấy {$orphanedMedia->count()} media orphaned.");

        if ($this->confirm('Bạn có muốn xóa chúng không?')) {
            $deletedCount = 0;

            foreach ($orphanedMedia as $media) {
                try {
                    $media->delete();
                    $deletedCount++;
                } catch (\Exception $e) {
                    $this->error("Lỗi khi xóa media ID {$media->id}: " . $e->getMessage());
                }
            }

            $this->info("Đã xóa {$deletedCount} media orphaned.");
        }
    }

    private function showStats()
    {
        $this->info('Thống kê Media:');
        $this->line('');

        $totalMedia = Media::count();
        $totalSize = Media::sum('size');
        $collections = Media::selectRaw('collection_name, COUNT(*) as count, SUM(size) as size')
                           ->groupBy('collection_name')
                           ->get();

        $this->line("Tổng số media: {$totalMedia}");
        $this->line("Tổng dung lượng: " . $this->formatBytes($totalSize));
        $this->line('');

        $this->line('Theo collection:');
        foreach ($collections as $collection) {
            $this->line("- {$collection->collection_name}: {$collection->count} files (" . $this->formatBytes($collection->size) . ")");
        }

        $this->line('');

        // Thống kê theo model
        $modelStats = Media::selectRaw('model_type, COUNT(*) as count')
                          ->groupBy('model_type')
                          ->get();

        $this->line('Theo model:');
        foreach ($modelStats as $stat) {
            $modelName = class_basename($stat->model_type);
            $this->line("- {$modelName}: {$stat->count} files");
        }
    }

    private function deleteMedia()
    {
        $mediaId = $this->option('id');

        if (!$mediaId) {
            $this->error('Vui lòng cung cấp --id để xóa media');
            return;
        }

        $media = Media::find($mediaId);

        if (!$media) {
            $this->error("Không tìm thấy media với ID: {$mediaId}");
            return;
        }

        $this->line("Media: {$media->name} ({$media->file_name})");
        $this->line("Collection: {$media->collection_name}");
        $this->line("Size: " . $this->formatBytes($media->size));

        if ($this->confirm('Bạn có chắc chắn muốn xóa media này không?')) {
            try {
                $media->delete();
                $this->info('Media đã được xóa thành công.');
            } catch (\Exception $e) {
                $this->error('Lỗi khi xóa media: ' . $e->getMessage());
            }
        }
    }

    private function regenerateConversions()
    {
        $this->info('Đang tạo lại conversions...');

        $mediaItems = Media::whereIn('collection_name', ['avatar', 'images'])->get();

        if ($mediaItems->isEmpty()) {
            $this->info('Không có media nào cần tạo lại conversions.');
            return;
        }

        $this->info("Tìm thấy {$mediaItems->count()} media cần tạo lại conversions.");

        $bar = $this->output->createProgressBar($mediaItems->count());
        $bar->start();

        $successCount = 0;
        $errorCount = 0;

        foreach ($mediaItems as $media) {
            try {
                $media->performConversions(['thumb', 'medium', 'large']);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("\nLỗi khi tạo conversions cho media ID {$media->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');

        $this->info("Hoàn thành! Thành công: {$successCount}, Lỗi: {$errorCount}");
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}