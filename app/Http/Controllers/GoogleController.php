<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;

class GoogleController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $token = $request->input('token');
        Log::info('Google Token:', ['code' => $token]);
        // Gửi yêu cầu lấy access token từ Google
        $response = Http::post('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $token,
        ]);

        if ($response->failed()) {
            Log::error('Google Token Error:', ['response' => $response->json()]);
            return response()->json(['status' => 'error', 'message' => 'Không thể xác thực', 'details' => $response->json()], 500);
        }

        $data = $response->json();
        $email = $data['email'];
        $name = $data['name'];
        $avatar = $data['picture'];

        // Tạo hoặc lấy người dùng
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(16)),
                'avatar' => $avatar,
            ]
        );

        $token = $user->createToken('GoogleAuth')->plainTextToken;

        // Trả về dữ liệu người dùng và token JWT
        return response()->json([
            'status' => 'success',
            'message' => 'Đăng nhập thành công!',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ],
        ]);
    }
}
