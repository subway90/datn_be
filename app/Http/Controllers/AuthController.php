<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Framework\Constraint\IsEmpty;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi xác thực',
                'errors' => $validator->errors()
            ], 422);
        }

        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tạo token cho người dùng
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json([
            'message' => 'Đăng ký thành công',
            'token' => $token,
            'user' => $user,
        ], 201); // Mã trạng thái 201 cho thành công
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Chưa nhập mật khẩu',
        ]);

        // Kiểm tra xem có lỗi xác thực không
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Kiểm tra email có tồn tại không
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email này chưa được đăng ký.'
            ], 404);
        }

        // Kiểm tra thông tin đăng nhập
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Mật khẩu không chính xác.'
            ], 401);
        }

        // Tạo token cho người dùng khi đăng nhập thành công
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        // Kiểm tra xem người dùng có đăng nhập không
        if (!auth()->user()) {
            return response()->json([
                'message' => 'Không có người dùng nào đang đăng nhập.'
            ], 400);
        }

        // Xoá token của người dùng
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công'
        ]);
    }

    public function profile(Request $request)
    {
        // Lấy người dùng đã xác thực
        $user = $request->user();

        // Kiểm tra xem người dùng có xác thực hay không
        if (!$user) {
            return response()->json(['message' => 'Token không hợp lệ'], 401);
        }

        return response()->json([$user], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Lấy người dùng đã xác thực
    
        // Kiểm tra xem có dữ liệu nào được gửi lên không
        if (!$request->hasAny(['name', 'phone', 'born'])) {
            return response()->json([
                'message' => 'Có lỗi xảy ra ! Có lẽ bạn chưa nhập dữ liệu cho key name|phone|born',
            ], 400); // Trả về mã 400 nếu không có dữ liệu
        }
    
        // Validate dữ liệu nếu có
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|size:10',
            'born' => 'nullable|date',
        ], [
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên vượt quá ký tự.',
            'phone.size' => 'SĐT phải có độ dài 10 ký tự.',
            'born.date' => 'Ngày sinh phải có định dạng hợp lệ.',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 422); // Trả về mã 422 nếu có lỗi xác thực
        }
    
        // Cập nhật các trường nếu có dữ liệu
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
    
        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }
    
        if ($request->has('born')) {
            $user->born = $request->input('born');
        }
    
        $user->save(); // Lưu các thay đổi vào cơ sở dữ liệu
    
        return response()->json([
            'message' => 'Thông tin người dùng đã được cập nhật thành công',
            'user' => $user,
        ]);
    }
}
