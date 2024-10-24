<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        $user = $request->user();

        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,webp,gif,png|max:2048',
            'phone' => 'nullable|size:10',
            'born' => 'nullable|date',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên vượt quá ký tự.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Chỉ chấp nhận các định dạng jpg, jpeg, webp, gif, png.',
            'avatar.max' => 'Kích thước tệp phải nhỏ hơn 2MB.',
            'phone.size' => 'SĐT phải có độ dài 10 ký tự.',
            'born.date' => 'Ngày sinh phải có định dạng hợp lệ.',
        ]);

        try {
            $user->update($request->only(['name', 'avatar', 'phone', 'born']));

            if ($request->file('avatar')) {
                if ($request->avatar) {
                    $oldImage = $user->avatar;
                    Storage::delete($oldImage);

                    $newImage = $user->file('avatar')->store('public/avatars');
                }

                $user->update([
                    "name" => $user->name,
                    "avatar" => $newImage,
                    "phone" => $user->phone,
                    "born" => $user->born
                ]);
            }

            $user->save();

            return response()->json([
                'message' => 'Thông tin người dùng đã được cập nhật thành công',
                'user' => $user,
                'avatar_url' =>  Storage::url('avatars/' . basename($user->avatar)),
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật thông tin người dùng: ' . $e->getMessage());
            return response()->json([
                'message' => 'Có lỗi xảy ra khi cập nhật thông tin người dùng.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate dữ liệu người dùng gửi lên
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,webp,gif,png|max:2048',
            'role' => 'required|integer|in:0,1',
            'phone' => 'nullable|size:10',
            'born' => 'nullable|date',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Chỉ chấp nhận các định dạng jpg, jpeg, webp, gif, png.',
            'avatar.max' => 'Kích thước tệp phải nhỏ hơn 2MB.',
            'phone.size' => 'Số điện thoại phải có độ dài 10 ký tự.',
            'born.date' => 'Ngày sinh phải là định dạng hợp lệ.',
            'role.required' => 'Vai trò là bắt buộc.',
            'role.in' => 'Vai trò không hợp lệ.',
        ]);

        // Trả về lỗi nếu không vượt qua validation
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Tạo mới người dùng
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->born = $request->input('born');

        // Nếu có avatar thì lưu vào storage
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Lưu thông tin người dùng
        $user->save();

        // Trả về response khi tạo mới người dùng thành công
        return response()->json([
            'message' => 'Người dùng đã được tạo thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? Storage::url($user->avatar) : null,
                'role' => $user->role,
                'phone' => $user->phone,
                'born' => $user->born,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ], 201);
    }

    // public function updateAvatar(Request $request)
    // {
    //     $user = $request->user();

    //     $request->validate([
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);


    //     // Xóa ảnh cũ nếu có
    //     if ($user->avatar) {
    //         Storage::delete($user->avatar);
    //     }

    //     // Lưu ảnh mới
    //     $imageName = time() . '.' . $request->avatar->extension();
    //     $imagePath = $request->avatar->storeAs('avatars', $imageName, 'public');

    //     // Resize ảnh (tùy chọn)
    //     // $img = Image::make(storage_path('app/public/' . $imagePath));
    //     // $img->resize(200, 200);
    //     // $img->save();

    //     // Cập nhật đường dẫn ảnh trong database
    //     $user->avatar = 'storage/' . $imagePath;
    //     $user->save();

    //     return response()->json(['message' => 'Ảnh đại diện đã được cập nhật']);
    // }
}

// if ($request->file('avatar')) {
//     $path = $request->file('avatar')->storage('public/avatars');

//     Storage::url($path);
// }

// if ($request->file('avatar')) {
//     $path = $user->avatar;
//     Storage::delete($path);

//     $pathImage = $user->file('avatar')->store('public/avatars');

//     $user->update([
//         "name" => $user->name,
//         "avatar" => $pathImage,
//         "phone" => $user->phone,
//         "born" => $user->born
//     ]);
// }
// $user->update([
//     "name" => $user->name,
//     "avatar" => $pathImage,
//     "phone" => $user->phone,
//     "born" => $user->born
// ]);
