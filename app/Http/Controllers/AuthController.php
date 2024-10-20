<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Đăng kí thành công'], 201);
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Kiểm tra thông tin đăng nhập
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Đăng nhập thất bại'], 401);
        }

        // Tạo token cho người dùng
        $user = auth()->user();
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        // Đăng xuất người dùng
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Đăng xuất thành công']);
    }
}