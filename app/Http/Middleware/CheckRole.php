<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để truy cập trang này.');
        }

        // Kiểm tra role của user
        if (!Auth::user()->hasRole($role)) {
            // Nếu không có quyền, chuyển về trang dashboard tương ứng
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Bạn không có quyền truy cập trang này.');
            } else {
                return redirect()->route('customer.dashboard')
                    ->with('error', 'Bạn không có quyền truy cập trang này.');
            }
        }

        return $next($request);
    }
}
