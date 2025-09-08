<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Upload single file
     */
    public function upload(FileUploadRequest $request): JsonResponse
    {
        try {
            $file = $request->file('file');
            $folder = $request->input('folder', 'uploads');
            $isImage = $request->input('is_image', false);

            $result = $this->fileUploadService->uploadFile($file, $folder, $isImage);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $result,
            ], 201);

        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Upload multiple files
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'files.*' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,xlsx,xls',
            'folder' => 'sometimes|string|max:255',
            'is_image' => 'sometimes|boolean',
        ]);

        try {
            $files = $request->file('files');
            $folder = $request->input('folder', 'uploads');
            $isImage = $request->input('is_image', false);

            $results = $this->fileUploadService->uploadMultipleFiles($files, $folder, $isImage);

            return response()->json([
                'success' => true,
                'message' => 'Files uploaded successfully',
                'data' => $results,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Multiple file upload failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Delete file
     */
    public function delete(Request $request): JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        try {
            $filePath = $request->input('file_path');
            $deleted = $this->fileUploadService->deleteFile($filePath);

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'File deleted successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found or could not be deleted',
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'File deletion failed: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get file info
     */
    public function info(Request $request): JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
        ]);

        try {
            $filePath = $request->input('file_path');
            $fileInfo = $this->fileUploadService->getFileInfo($filePath);

            if ($fileInfo) {
                return response()->json([
                    'success' => true,
                    'data' => $fileInfo,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found',
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Get file info failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get file info: ' . $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get file URL with thumbnail
     */
    public function url(Request $request): JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
            'size' => 'sometimes|string|in:original,thumb,medium,large',
        ]);

        try {
            $filePath = $request->input('file_path');
            $size = $request->input('size', 'original');
            $url = $this->fileUploadService->getFileUrl($filePath, $size);

            return response()->json([
                'success' => true,
                'data' => [
                    'url' => $url,
                    'size' => $size,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Get file URL failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get file URL: ' . $e->getMessage(),
            ], 400);
        }
    }
}