<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Services\QueryBuilderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaQueryController extends Controller
{
    /**
     * Display a listing of media with query builder
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Validate query parameters
            $errors = QueryBuilderService::validateQuery($request);
            if (!empty($errors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid query parameters',
                    'errors' => $errors
                ], 400);
            }

            // Build query with Query Builder
            $queryBuilder = QueryBuilderService::forMedia(Media::query(), $request);
            
            // Get paginated results
            $result = QueryBuilderService::response($queryBuilder, $request->get('per_page', 15));
            
            // Transform data with MediaResource
            $result['data'] = MediaResource::collection($result['data']);
            
            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified media
     */
    public function show(Media $media): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Media retrieved successfully',
                'data' => new MediaResource($media->load('model'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available filters for media
     */
    public function filters(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'filters' => QueryBuilderService::getAvailableFilters('media'),
                'sorts' => QueryBuilderService::getAvailableSorts('media'),
                'includes' => QueryBuilderService::getAvailableIncludes('media'),
            ]
        ]);
    }

    /**
     * Get media statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total_media' => Media::count(),
                'total_size' => Media::sum('size'),
                'by_collection' => Media::selectRaw('collection_name, COUNT(*) as count, SUM(size) as size')
                    ->groupBy('collection_name')
                    ->get(),
                'by_mime_type' => Media::selectRaw('mime_type, COUNT(*) as count')
                    ->groupBy('mime_type')
                    ->orderBy('count', 'desc')
                    ->get(),
                'by_model' => Media::selectRaw('model_type, COUNT(*) as count')
                    ->groupBy('model_type')
                    ->get(),
                'recent_media' => Media::where('created_at', '>=', now()->subDays(7))->count(),
                'media_by_month' => Media::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving media statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search media
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');
            $perPage = $request->get('per_page', 15);

            if (empty($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query is required'
                ], 400);
            }

            $media = Media::where('name', 'like', "%{$query}%")
                ->orWhere('file_name', 'like', "%{$query}%")
                ->orWhere('mime_type', 'like', "%{$query}%")
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Search completed',
                'data' => MediaResource::collection($media->items()),
                'pagination' => [
                    'current_page' => $media->currentPage(),
                    'per_page' => $media->perPage(),
                    'total' => $media->total(),
                    'last_page' => $media->lastPage(),
                    'from' => $media->firstItem(),
                    'to' => $media->lastItem(),
                    'has_more_pages' => $media->hasMorePages(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get media by collection
     */
    public function byCollection(Request $request, string $collection): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            
            $media = Media::where('collection_name', $collection)
                ->with('model')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => "Media in collection '{$collection}' retrieved successfully",
                'data' => MediaResource::collection($media->items()),
                'pagination' => [
                    'current_page' => $media->currentPage(),
                    'per_page' => $media->perPage(),
                    'total' => $media->total(),
                    'last_page' => $media->lastPage(),
                    'from' => $media->firstItem(),
                    'to' => $media->lastItem(),
                    'has_more_pages' => $media->hasMorePages(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving media by collection: ' . $e->getMessage()
            ], 500);
        }
    }
}