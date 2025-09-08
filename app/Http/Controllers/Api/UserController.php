<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\QueryBuilderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of users with query builder
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
            $queryBuilder = QueryBuilderService::forUsers(User::query(), $request);
            
            // Get paginated results
            $result = QueryBuilderService::response($queryBuilder, $request->get('per_page', 15));
            
            // Transform data with UserResource
            $result['data'] = UserResource::collection($result['data']);
            
            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user
     */
    public function show(User $user): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => new UserResource($user->load(['roles', 'permissions', 'media']))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available filters for users
     */
    public function filters(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'filters' => QueryBuilderService::getAvailableFilters('users'),
                'sorts' => QueryBuilderService::getAvailableSorts('users'),
                'includes' => QueryBuilderService::getAvailableIncludes('users'),
            ]
        ]);
    }

    /**
     * Get user statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'admin_users' => User::role('admin')->count(),
                'regular_users' => User::role('user')->count(),
                'users_with_media' => User::has('media')->count(),
                'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
                'users_by_month' => User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
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
                'message' => 'Error retrieving user statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search users
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

            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone', 'like', "%{$query}%")
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Search completed',
                'data' => UserResource::collection($users->items()),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                    'has_more_pages' => $users->hasMorePages(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching users: ' . $e->getMessage()
            ], 500);
        }
    }
}