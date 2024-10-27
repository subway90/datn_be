<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class Admin
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
            return response()->json(['message' => 'Bạn chưa đăng nhập !'], 404);
        }

        // Sử dụng findToken để kiểm tra token hợp lệ
        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken || !$accessToken->tokenable) {
            // Nếu token không hợp lệ hoặc không có user tương ứng, trả về lỗi
            return response()->json(['message' => 'Bạn chưa đăng nhập !'], 404);
        }

        // Xác thực người dùng
        $user = $accessToken->tokenable;

        // Kiểm tra vai trò của người dùng
        if ($user->role == 1) {
            // Nếu role là 1, trả về lỗi 401
            return response()->json(['message' => 'Bạn không có quyền truy cập.'], 401);
        }

        // Nếu role là 0, tiếp tục xử lý yêu cầu
        \Auth::login($user);

        return $next($request);
    }
}