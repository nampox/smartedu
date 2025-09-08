<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileUploadService
{
    protected $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    protected $allowedDocumentTypes = ['pdf', 'doc', 'docx', 'txt', 'xlsx', 'xls'];
    protected $maxFileSize = 10240; // 10MB in KB

    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Upload file lên storage
     */
    public function uploadFile(UploadedFile $file, string $folder = 'uploads', bool $isImage = false): array
    {
        // Kiểm tra tính hợp lệ của file
        $this->validateFile($file, $isImage);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = $this->generateFileName($originalName, $extension);
        $filePath = $folder . '/' . $fileName;

        // Lưu file vào storage
        $storedPath = $file->storeAs($folder, $fileName, 'public');

        // Nếu là hình ảnh, tạo thumbnail
        if ($isImage) {
            $this->createImageThumbnails($storedPath);
        }

        return [
            'original_name' => $originalName,
            'file_name' => $fileName,
            'file_path' => $storedPath,
            'file_url' => Storage::url($storedPath),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'extension' => $extension,
        ];
    }

    /**
     * Upload nhiều file cùng lúc
     */
    public function uploadMultipleFiles(array $files, string $folder = 'uploads', bool $isImage = false): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedFiles[] = $this->uploadFile($file, $folder, $isImage);
            }
        }

        return $uploadedFiles;
    }

    /**
     * Xóa file khỏi storage
     */
    public function deleteFile(string $filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            // Xóa file chính
            Storage::disk('public')->delete($filePath);

            // Xóa thumbnail nếu là hình ảnh
            $this->deleteImageThumbnails($filePath);

            return true;
        }

        return false;
    }

    /**
     * Lấy thông tin chi tiết của file
     */
    public function getFileInfo(string $filePath): ?array
    {
        if (!Storage::disk('public')->exists($filePath)) {
            return null;
        }

        $fullPath = Storage::disk('public')->path($filePath);

        return [
            'file_path' => $filePath,
            'file_url' => Storage::url($filePath),
            'file_size' => filesize($fullPath),
            'mime_type' => mime_content_type($fullPath),
            'last_modified' => filemtime($fullPath),
        ];
    }

    /**
     * Kiểm tra tính hợp lệ của file
     */
    protected function validateFile(UploadedFile $file, bool $isImage = false): void
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileSize = $file->getSize() / 1024; // Chuyển đổi sang KB

        // Kiểm tra kích thước file
        if ($fileSize > $this->maxFileSize) {
            throw new \Exception('File size exceeds maximum allowed size of ' . $this->maxFileSize . 'KB');
        }

        // Kiểm tra loại file
        if ($isImage) {
            if (!in_array($extension, $this->allowedImageTypes)) {
                throw new \Exception('Invalid image type. Allowed types: ' . implode(', ', $this->allowedImageTypes));
            }
        } else {
            $allowedTypes = array_merge($this->allowedImageTypes, $this->allowedDocumentTypes);
            if (!in_array($extension, $allowedTypes)) {
                throw new \Exception('Invalid file type. Allowed types: ' . implode(', ', $allowedTypes));
            }
        }
    }

    /**
     * Tạo tên file duy nhất
     */
    protected function generateFileName(string $originalName, string $extension): string
    {
        $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
        $sanitizedName = Str::slug($nameWithoutExtension);
        $timestamp = now()->format('Y_m_d_H_i_s');
        $randomString = Str::random(8);

        return $sanitizedName . '_' . $timestamp . '_' . $randomString . '.' . $extension;
    }

    /**
     * Tạo thumbnail cho hình ảnh
     */
    protected function createImageThumbnails(string $filePath): void
    {
        $fullPath = Storage::disk('public')->path($filePath);
        $pathInfo = pathinfo($filePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        // Các kích thước thumbnail
        $sizes = [
            'thumb' => [150, 150],
            'medium' => [300, 300],
            'large' => [600, 600],
        ];

        foreach ($sizes as $sizeName => $dimensions) {
            $thumbnailPath = $directory . '/' . $filename . '_' . $sizeName . '.' . $extension;
            $thumbnailFullPath = Storage::disk('public')->path($thumbnailPath);

        try {
            // Sử dụng Intervention Image để tạo thumbnail
            $manager = new ImageManager(new Driver());
            $image = $manager->read($fullPath);
            $image->resize($dimensions[0], $dimensions[1]);
            $image->save($thumbnailFullPath);
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm fail upload
            \Illuminate\Support\Facades\Log::error('Failed to create thumbnail: ' . $e->getMessage());
        }
        }
    }

    /**
     * Xóa các thumbnail của hình ảnh
     */
    protected function deleteImageThumbnails(string $filePath): void
    {
        $pathInfo = pathinfo($filePath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        $sizes = ['thumb', 'medium', 'large'];

        foreach ($sizes as $sizeName) {
            $thumbnailPath = $directory . '/' . $filename . '_' . $sizeName . '.' . $extension;
            Storage::disk('public')->delete($thumbnailPath);
        }
    }

    /**
     * Lấy URL file với thumbnail
     */
    public function getFileUrl(string $filePath, string $size = 'original'): string
    {
        if ($size === 'original') {
            return Storage::url($filePath);
        }

        $pathInfo = pathinfo($filePath);
        $thumbnailPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $size . '.' . $pathInfo['extension'];

        if (Storage::disk('public')->exists($thumbnailPath)) {
            return Storage::url($thumbnailPath);
        }

        return Storage::url($filePath);
    }

    /**
     * Upload file sử dụng Media Library
     */
    public function uploadFileToMedia(HasMedia $model, UploadedFile $file, string $collection = 'default', array $customProperties = []): Media
    {
        return $this->mediaService->uploadFile($model, $file, $collection, $customProperties);
    }

    /**
     * Upload multiple files sử dụng Media Library
     */
    public function uploadMultipleFilesToMedia(HasMedia $model, array $files, string $collection = 'default', array $customProperties = []): array
    {
        return $this->mediaService->uploadMultipleFiles($model, $files, $collection, $customProperties);
    }

    /**
     * Upload avatar cho user
     */
    public function uploadUserAvatar(HasMedia $user, UploadedFile $file): Media
    {
        // Xóa avatar cũ nếu có
        $user->clearMediaCollection('avatar');

        return $this->uploadFileToMedia($user, $file, 'avatar', [
            'type' => 'avatar',
            'uploaded_at' => now()->toISOString(),
        ]);
    }

    /**
     * Upload document cho user
     */
    public function uploadUserDocument(HasMedia $user, UploadedFile $file, array $customProperties = []): Media
    {
        return $this->uploadFileToMedia($user, $file, 'documents', array_merge($customProperties, [
            'type' => 'document',
            'uploaded_at' => now()->toISOString(),
        ]));
    }

    /**
     * Upload image cho user
     */
    public function uploadUserImage(HasMedia $user, UploadedFile $file, array $customProperties = []): Media
    {
        return $this->uploadFileToMedia($user, $file, 'images', array_merge($customProperties, [
            'type' => 'image',
            'uploaded_at' => now()->toISOString(),
        ]));
    }

    /**
     * Lấy media URLs cho collection
     */
    public function getMediaCollectionUrls(HasMedia $model, string $collection, string $conversion = ''): array
    {
        return $this->mediaService->getCollectionUrls($model, $collection, $conversion);
    }

    /**
     * Xóa media
     */
    public function deleteMedia(Media $media): bool
    {
        return $this->mediaService->deleteMedia($media);
    }

    /**
     * Lấy thống kê media của user
     */
    public function getUserMediaStats(HasMedia $user): array
    {
        return $this->mediaService->getUserMediaStats($user);
    }

    /**
     * Validate file cho collection
     */
    public function validateFileForCollection(UploadedFile $file, string $collection): bool
    {
        return $this->mediaService->validateFileForCollection($file, $collection);
    }
}
