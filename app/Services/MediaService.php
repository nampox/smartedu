<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Str;

class MediaService
{
    /**
     * Upload file và gán vào model
     */
    public function uploadFile(HasMedia $model, UploadedFile $file, string $collection = 'default', array $customProperties = []): Media
    {
        $media = $model->addMediaFromRequest($file)
            ->usingName($this->generateFileName($file))
            ->usingFileName($this->generateUniqueFileName($file))
            ->withCustomProperties($customProperties)
            ->toMediaCollection($collection);

        return $media;
    }

    /**
     * Upload multiple files
     */
    public function uploadMultipleFiles(HasMedia $model, array $files, string $collection = 'default', array $customProperties = []): array
    {
        $uploadedMedia = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedMedia[] = $this->uploadFile($model, $file, $collection, $customProperties);
            }
        }

        return $uploadedMedia;
    }

    /**
     * Upload file từ URL
     */
    public function uploadFromUrl(HasMedia $model, string $url, string $collection = 'default', array $customProperties = []): Media
    {
        $media = $model->addMediaFromUrl($url)
            ->usingName($this->generateNameFromUrl($url))
            ->usingFileName($this->generateUniqueFileNameFromUrl($url))
            ->withCustomProperties($customProperties)
            ->toMediaCollection($collection);

        return $media;
    }

    /**
     * Xóa media
     */
    public function deleteMedia(Media $media): bool
    {
        try {
            $media->delete();
            return true;
        } catch (\Exception $e) {
            \Log::error('Error deleting media: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Xóa tất cả media trong collection
     */
    public function clearCollection(HasMedia $model, string $collection): bool
    {
        try {
            $model->clearMediaCollection($collection);
            return true;
        } catch (\Exception $e) {
            \Log::error('Error clearing collection: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy media URL với conversion
     */
    public function getMediaUrl(Media $media, string $conversion = ''): string
    {
        if ($conversion) {
            return $media->getUrl($conversion);
        }

        return $media->getUrl();
    }

    /**
     * Lấy media URLs cho collection
     */
    public function getCollectionUrls(HasMedia $model, string $collection, string $conversion = ''): array
    {
        $mediaItems = $model->getMedia($collection);
        $urls = [];

        foreach ($mediaItems as $media) {
            $urls[] = [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'size' => $media->size,
                'url' => $this->getMediaUrl($media, $conversion),
                'original_url' => $this->getMediaUrl($media),
                'custom_properties' => $media->custom_properties,
                'created_at' => $media->created_at,
            ];
        }

        return $urls;
    }

    /**
     * Tạo conversion cho media
     */
    public function createConversion(Media $media, string $conversionName, int $width, int $height): bool
    {
        try {
            $media->performConversions([$conversionName]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Error creating conversion: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate file name từ uploaded file
     */
    private function generateFileName(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return Str::slug($originalName);
    }

    /**
     * Generate unique file name
     */
    private function generateUniqueFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = Str::random(40);
        return $name . '.' . $extension;
    }

    /**
     * Generate name từ URL
     */
    private function generateNameFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $filename = basename($path);
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    /**
     * Generate unique file name từ URL
     */
    private function generateUniqueFileNameFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $name = Str::random(40);
        return $name . '.' . $extension;
    }

    /**
     * Validate file type cho collection
     */
    public function validateFileForCollection(UploadedFile $file, string $collection): bool
    {
        $allowedMimeTypes = $this->getAllowedMimeTypesForCollection($collection);
        
        return in_array($file->getMimeType(), $allowedMimeTypes);
    }

    /**
     * Lấy allowed mime types cho collection
     */
    private function getAllowedMimeTypesForCollection(string $collection): array
    {
        $mimeTypes = [
            'avatar' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            'documents' => [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
            'images' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
        ];

        return $mimeTypes[$collection] ?? ['*/*'];
    }

    /**
     * Lấy thống kê media của user
     */
    public function getUserMediaStats(User $user): array
    {
        $stats = [
            'total_files' => 0,
            'total_size' => 0,
            'collections' => [],
        ];

        $collections = ['avatar', 'documents', 'images'];

        foreach ($collections as $collection) {
            $mediaItems = $user->getMedia($collection);
            $collectionStats = [
                'count' => $mediaItems->count(),
                'size' => $mediaItems->sum('size'),
                'files' => [],
            ];

            foreach ($mediaItems as $media) {
                $collectionStats['files'][] = [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'created_at' => $media->created_at,
                ];
            }

            $stats['collections'][$collection] = $collectionStats;
            $stats['total_files'] += $collectionStats['count'];
            $stats['total_size'] += $collectionStats['size'];
        }

        return $stats;
    }
}
