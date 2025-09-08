<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\Exceptions\InvalidSortQuery;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery;

class QueryBuilderService
{
    /**
     * Tạo QueryBuilder cho model
     */
    public static function for(Builder $query, Request $request = null): QueryBuilder
    {
        $request = $request ?: request();
        
        return QueryBuilder::for($query, $request)
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id', 'name', 'email', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                'id', 'name', 'email', 'created_at', 'updated_at'
            ])
            ->allowedIncludes([
                'roles', 'media'
            ]);
    }

    /**
     * Tạo QueryBuilder cho User model
     */
    public static function forUsers(Builder $query, Request $request = null): QueryBuilder
    {
        $request = $request ?: request();
        
        return QueryBuilder::for($query, $request)
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id', 'name', 'email', 'phone', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                'id',
                'name',
                'email',
                'phone',
                AllowedFilter::exact('roles.name'),
                AllowedFilter::scope('has_role'),
                AllowedFilter::scope('has_permission'),
                AllowedFilter::scope('created_between'),
                AllowedFilter::scope('search'),
            ])
            ->allowedIncludes([
                'roles', 'permissions', 'media'
            ]);
    }

    /**
     * Tạo QueryBuilder cho Media model
     */
    public static function forMedia(Builder $query, Request $request = null): QueryBuilder
    {
        $request = $request ?: request();
        
        return QueryBuilder::for($query, $request)
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id', 'name', 'file_name', 'mime_type', 'size', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                'id',
                'name',
                'file_name',
                'mime_type',
                'collection_name',
                'disk',
                AllowedFilter::exact('model_type'),
                AllowedFilter::exact('model_id'),
                AllowedFilter::scope('by_collection'),
                AllowedFilter::scope('by_mime_type'),
                AllowedFilter::scope('by_size_range'),
                AllowedFilter::scope('by_date_range'),
            ])
            ->allowedIncludes([
                'model'
            ]);
    }

    /**
     * Tạo QueryBuilder cho Role model
     */
    public static function forRoles(Builder $query, Request $request = null): QueryBuilder
    {
        $request = $request ?: request();
        
        return QueryBuilder::for($query, $request)
            ->defaultSort('name')
            ->allowedSorts([
                'id', 'name', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                'id',
                'name',
                AllowedFilter::scope('has_permission'),
                AllowedFilter::scope('search'),
            ])
            ->allowedIncludes([
                'permissions', 'users'
            ]);
    }

    /**
     * Tạo QueryBuilder cho Permission model
     */
    public static function forPermissions(Builder $query, Request $request = null): QueryBuilder
    {
        $request = $request ?: request();
        
        return QueryBuilder::for($query, $request)
            ->defaultSort('name')
            ->allowedSorts([
                'id', 'name', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                'id',
                'name',
                AllowedFilter::scope('by_guard'),
                AllowedFilter::scope('search'),
            ])
            ->allowedIncludes([
                'roles', 'users'
            ]);
    }

    /**
     * Xử lý pagination với custom parameters
     */
    public static function paginate(QueryBuilder $queryBuilder, int $perPage = 15, int $maxPerPage = 100): array
    {
        $perPage = min($perPage, $maxPerPage);
        
        $result = $queryBuilder->paginate($perPage);
        
        return [
            'data' => $result->items(),
            'pagination' => [
                'current_page' => $result->currentPage(),
                'per_page' => $result->perPage(),
                'total' => $result->total(),
                'last_page' => $result->lastPage(),
                'from' => $result->firstItem(),
                'to' => $result->lastItem(),
                'has_more_pages' => $result->hasMorePages(),
            ],
            'links' => [
                'first' => $result->url(1),
                'last' => $result->url($result->lastPage()),
                'prev' => $result->previousPageUrl(),
                'next' => $result->nextPageUrl(),
            ]
        ];
    }

    /**
     * Xử lý response với metadata
     */
    public static function response(QueryBuilder $queryBuilder, int $perPage = 15): array
    {
        $result = self::paginate($queryBuilder, $perPage);
        
        return [
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $result['data'],
            'pagination' => $result['pagination'],
            'links' => $result['links'],
            'meta' => [
                'query_time' => microtime(true) - LARAVEL_START,
                'filters_applied' => request()->get('filter', []),
                'sorts_applied' => request()->get('sort', []),
                'includes_applied' => request()->get('include', []),
            ]
        ];
    }

    /**
     * Validate query parameters
     */
    public static function validateQuery(Request $request): array
    {
        $errors = [];
        
        // Validate sort parameters
        if ($request->has('sort')) {
            $sorts = is_array($request->get('sort')) ? $request->get('sort') : [$request->get('sort')];
            foreach ($sorts as $sort) {
                if (!preg_match('/^-?[a-zA-Z_][a-zA-Z0-9_]*$/', $sort)) {
                    $errors[] = "Invalid sort parameter: {$sort}";
                }
            }
        }
        
        // Validate filter parameters
        if ($request->has('filter')) {
            $filters = $request->get('filter', []);
            foreach ($filters as $key => $value) {
                if (!is_string($key) || (!is_string($value) && !is_numeric($value) && !is_array($value))) {
                    $errors[] = "Invalid filter parameter: {$key}";
                }
            }
        }
        
        // Validate include parameters
        if ($request->has('include')) {
            $includes = is_array($request->get('include')) ? $request->get('include') : [$request->get('include')];
            foreach ($includes as $include) {
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_.]*$/', $include)) {
                    $errors[] = "Invalid include parameter: {$include}";
                }
            }
        }
        
        return $errors;
    }

    /**
     * Get available filters for a model
     */
    public static function getAvailableFilters(string $model): array
    {
        $filters = [
            'users' => [
                'id', 'name', 'email', 'phone', 'created_at', 'updated_at',
                'roles.name', 'has_role', 'has_permission', 'created_between', 'search'
            ],
            'media' => [
                'id', 'name', 'file_name', 'mime_type', 'collection_name', 'disk',
                'model_type', 'model_id', 'by_collection', 'by_mime_type', 'by_size_range', 'by_date_range'
            ],
            'roles' => [
                'id', 'name', 'has_permission', 'search'
            ],
            'permissions' => [
                'id', 'name', 'by_guard', 'search'
            ]
        ];
        
        return $filters[$model] ?? [];
    }

    /**
     * Get available sorts for a model
     */
    public static function getAvailableSorts(string $model): array
    {
        $sorts = [
            'users' => ['id', 'name', 'email', 'phone', 'created_at', 'updated_at'],
            'media' => ['id', 'name', 'file_name', 'mime_type', 'size', 'created_at', 'updated_at'],
            'roles' => ['id', 'name', 'created_at', 'updated_at'],
            'permissions' => ['id', 'name', 'created_at', 'updated_at']
        ];
        
        return $sorts[$model] ?? [];
    }

    /**
     * Get available includes for a model
     */
    public static function getAvailableIncludes(string $model): array
    {
        $includes = [
            'users' => ['roles', 'permissions', 'media'],
            'media' => ['model'],
            'roles' => ['permissions', 'users'],
            'permissions' => ['roles', 'users']
        ];
        
        return $includes[$model] ?? [];
    }
}
