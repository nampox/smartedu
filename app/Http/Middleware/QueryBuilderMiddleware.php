<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\QueryBuilderService;

class QueryBuilderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để truy cập API này'
            ], 401);
        }

        // Kiểm tra permission nếu được cung cấp
        if ($permission && !auth()->user()->can($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập API này'
            ], 403);
        }

        // Validate query parameters
        $errors = QueryBuilderService::validateQuery($request);
        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid query parameters',
                'errors' => $errors
            ], 400);
        }

        // Kiểm tra rate limiting cho query builder
        $this->checkRateLimit($request);

        return $next($request);
    }

    /**
     * Kiểm tra rate limiting
     */
    private function checkRateLimit(Request $request): void
    {
        $key = 'query_builder:' . auth()->id();
        $maxAttempts = 100; // 100 requests per minute
        $decayMinutes = 1;

        $attempts = cache()->get($key, 0);
        
        if ($attempts >= $maxAttempts) {
            abort(429, 'Too many query requests. Please try again later.');
        }

        cache()->put($key, $attempts + 1, now()->addMinutes($decayMinutes));
    }
}