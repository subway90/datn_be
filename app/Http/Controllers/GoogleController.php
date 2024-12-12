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

        // Xác thực token với Google
        $response = Http::post('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $token,
        ]);

        if ($response->failed()) {
            Log::error('Google Token Error:', ['response' => $response->json()]);
            return response()->json(['status' => 'error', 'message' => 'Không thể xác thực', 'details' => $response->json()], 500);
        }

        $data = $response->json();
        $email = $data['email'];

        // Kiểm tra người dùng đã tồn tại
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng chưa đăng ký!',
            ], 404);
        }

        $token = $user->createToken('LoginGoogle')->plainTextToken;

        // Trả về thông tin người dùng và token
        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'ten' => $user->ten,
                    'email' => $user->email,
                ],
            ],
        ]);
    }

    public function registerWithGoogle(Request $request)
    {
        $token = $request->input('token');
        Log::info('Google Token:', ['code' => $token]);

        // Xác thực token với Google
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
        $googleId = $data['sub'];

        // Kiểm tra người dùng đã tồn tại
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng đã tồn tại!',
            ], 409);
        }

        // Tạo người dùng mới
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => bcrypt(Str::random(16)),
            'avatar' => $avatar,
            'google_id' => $googleId,
        ]);

        $token = $user->createToken('RegisterGoogle')->plainTextToken;

        // Trả về thông tin người dùng và token
        return response()->json([
            'message' => 'Đăng ký thành công!',
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
