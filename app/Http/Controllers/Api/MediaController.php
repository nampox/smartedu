<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Services\FileUploadService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    protected $fileUploadService;
    protected $mediaService;

    public function __construct(FileUploadService $fileUploadService, MediaService $mediaService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->mediaService = $mediaService;
    }

    /**
     * Upload avatar cho user hiện tại
     */
    public function uploadAvatar(FileUploadRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $file = $request->file('file');

            // Validate file type cho avatar
            if (!$this->fileUploadService->validateFileForCollection($file, 'avatar')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loại file không được hỗ trợ cho avatar. Chỉ chấp nhận: JPG, PNG, GIF, WEBP'
                ], 400);
            }

            $media = $this->fileUploadService->uploadUserAvatar($user, $file);

            return response()->json([
                'success' => true,
                'message' => 'Avatar đã được upload thành công',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'thumb_url' => $media->getUrl('thumb'),
                    'medium_url' => $media->getUrl('medium'),
                    'custom_properties' => $media->custom_properties,
                    'created_at' => $media->created_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi upload avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload document cho user hiện tại
     */
    public function uploadDocument(FileUploadRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $file = $request->file('file');

            // Validate file type cho documents
            if (!$this->fileUploadService->validateFileForCollection($file, 'documents')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loại file không được hỗ trợ cho documents. Chỉ chấp nhận: PDF, DOC, DOCX, TXT, XLS, XLSX'
                ], 400);
            }

            $customProperties = $request->input('custom_properties', []);
            $media = $this->fileUploadService->uploadUserDocument($user, $file, $customProperties);

            return response()->json([
                'success' => true,
                'message' => 'Document đã được upload thành công',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'custom_properties' => $media->custom_properties,
                    'created_at' => $media->created_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi upload document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload image cho user hiện tại
     */
    public function uploadImage(FileUploadRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $file = $request->file('file');

            // Validate file type cho images
            if (!$this->fileUploadService->validateFileForCollection($file, 'images')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Loại file không được hỗ trợ cho images. Chỉ chấp nhận: JPG, PNG, GIF, WEBP, SVG'
                ], 400);
            }

            $customProperties = $request->input('custom_properties', []);
            $media = $this->fileUploadService->uploadUserImage($user, $file, $customProperties);

            return response()->json([
                'success' => true,
                'message' => 'Image đã được upload thành công',
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'url' => $media->getUrl(),
                    'thumb_url' => $media->getUrl('thumb'),
                    'medium_url' => $media->getUrl('medium'),
                    'large_url' => $media->getUrl('large'),
                    'custom_properties' => $media->custom_properties,
                    'created_at' => $media->created_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách media của user hiện tại
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $collection = $request->input('collection', 'all');
            $conversion = $request->input('conversion', '');

            $collections = ['avatar', 'documents', 'images'];
            $mediaData = [];

            if ($collection === 'all') {
                foreach ($collections as $col) {
                    $mediaData[$col] = $this->fileUploadService->getMediaCollectionUrls($user, $col, $conversion);
                }
            } else {
                if (in_array($collection, $collections)) {
                    $mediaData[$collection] = $this->fileUploadService->getMediaCollectionUrls($user, $collection, $conversion);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Collection không hợp lệ'
                    ], 400);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $mediaData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin chi tiết của media
     */
    public function show(Media $media): JsonResponse
    {
        try {
            $user = Auth::user();

            // Kiểm tra quyền truy cập
            if ($media->model_type !== get_class($user) || $media->model_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền truy cập media này'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'mime_type' => $media->mime_type,
                    'size' => $media->size,
                    'collection_name' => $media->collection_name,
                    'url' => $media->getUrl(),
                    'thumb_url' => $media->getUrl('thumb'),
                    'medium_url' => $media->getUrl('medium'),
                    'large_url' => $media->getUrl('large'),
                    'custom_properties' => $media->custom_properties,
                    'created_at' => $media->created_at,
                    'updated_at' => $media->updated_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa media
     */
    public function destroy(Media $media): JsonResponse
    {
        try {
            $user = Auth::user();

            // Kiểm tra quyền truy cập
            if ($media->model_type !== get_class($user) || $media->model_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền xóa media này'
                ], 403);
            }

            $success = $this->fileUploadService->deleteMedia($media);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Media đã được xóa thành công'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi xóa media'
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thống kê media của user hiện tại
     */
    public function stats(): JsonResponse
    {
        try {
            $user = Auth::user();
            $stats = $this->fileUploadService->getUserMediaStats($user);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thống kê media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download media file
     */
    public function download(Media $media): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        try {
            $user = Auth::user();

            // Kiểm tra quyền truy cập
            if ($media->model_type !== get_class($user) || $media->model_id !== $user->id) {
                abort(403, 'Không có quyền download media này');
            }

            return response()->download($media->getPath(), $media->file_name);

        } catch (\Exception $e) {
            abort(500, 'Lỗi khi download media: ' . $e->getMessage());
        }
    }
}