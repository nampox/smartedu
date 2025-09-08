<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Xử lý request đến middleware
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }

        // Kiểm tra user có permission không
        if (! Auth::user()->can($permission)) {
            return redirect()->route('home')
                ->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        return $next($request);
    }
}