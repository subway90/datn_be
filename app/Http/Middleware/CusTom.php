<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
class CusTom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy token từ header Authorization
        $token = $request->bearerToken();

        if (!$token) {
            // Nếu không có token, trả về phản hồi lỗi
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        }

        // Sử dụng findToken để kiểm tra token hợp lệ
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable) {
            // Nếu token không hợp lệ hoặc không có user tương ứng, trả về lỗi
            return response()->json(['message' => 'Bạn chưa đăng nhập'], 401);
        }

        // Xác thực người dùng
        \Auth::login($accessToken->tokenable);

        return $next($request);
    }
}
