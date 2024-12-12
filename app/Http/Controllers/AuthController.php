<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\IsEmpty;
use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
    public function one($id)
    {
        $result = User::find($id);
        if (!$result)
            return response()->json(['message' => 'ID này không tồn tại'], 404);
        return response()->json(['user' => $result], 200);
    }
    public function all()
    {
        $result = User::get();
        return response()->json(['list' => $result], 200);
    }
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Chưa nhập họ và tên',
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400);
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
        $token = $user->createToken('ID USER: ' . $user->id)->plainTextToken;

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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|size:10',
            'born' => 'nullable|date',
            'address' => 'nullable',
            'gender' => 'boolean',
        ], [
            'name.required' => 'Tên chưa được nhập',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên vượt quá ký tự.',
            'phone.size' => 'SĐT phải có độ dài 10 ký tự.',
            'born.date' => 'Ngày sinh phải có định dạng hợp lệ.',
            'gender.boolean' => 'Vui lòng nhập định dạng 0 hoặc 1 cho gender (0:nam, 1:nữ)',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400);
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

        if ($request->has('address')) {
            $user->address = $request->input('address');
        }

        if ($request->has('gender')) {
            $user->gender = $request->input('gender');
        }

        $user->save(); // Lưu các thay đổi vào cơ sở dữ liệu

        return response()->json([
            'message' => 'Cập nhật thành công !',
        ], 200);
    }
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'avatar.image' => 'File tải lên phải là một ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận các định dạng: jpeg, png, jpg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400);
        }

        $user = $request->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatar', 'public');

        $user->avatar = $path;
        $user->save();

        return response()->json([
            'message' => 'Thay đổi ảnh đại diện thành công!',
            'avatar_url' => Storage::url($path)
        ], 200);
    }
    public function editUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Id user không tồn tại'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'nullable|integer|min:1', // Thay đổi thành nullable
            'phone' => 'nullable|string|max:10',
            'born' => 'nullable|date'
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'role.integer' => 'Vai trò phải là một số nguyên.',
            'role.min' => 'Vai trò phải lớn hơn hoặc bằng 1.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được dài quá 10 ký tự.',
            'born.date' => 'Ngày sinh phải là định dạng ngày hợp lệ.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Chỉ cập nhật nếu có thay đổi
        $updatedFields = [];

        if ($request->has('role') && !$request->has('role') && $request->role !== $user->role) {
            $updatedFields['role'] = $request->role;
        }

        if ($request->has('born') && !$request->has('born') && $request->born !== $user->born) {
            $updatedFields['born'] = $request->born;
        }

        if ($request->has('phone') && $request->phone !== $user->phone) {
            $updatedFields['phone'] = $request->phone;
        }

        // Cập nhật tên người dùng
        $user->name = $request->name; // Cập nhật tên luôn

        // Nếu có trường nào được thay đổi thì cập nhật
        if (!empty($updatedFields)) {
            $user->update($updatedFields);
        }

        // Lưu tên vào cơ sở dữ liệu
        $user->save();

        return response()->json(['message' => 'Chỉnh sửa thông tin thành công!', 'user' => $user], 200);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Id user không tồn tại'], 404);
        }

        if ($user->role == 0) {
            return response()->json(['error' => 'Không được xóa tài khoản admin'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'Xóa thành công!'], 200);
    }
    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return response()->json(['error' => 'Id user không tồn tại'], 404);
        }

        $user->restore();

        return response()->json(['message' => 'Khôi phục thành công!', 'user' => $user], 200);
    }
    public function getDeletedUsers()
    {
        $deletedUsers = User::onlyTrashed()->get();

        if ($deletedUsers->isEmpty()) {
            return response()->json(['message' => 'Không có user nào đã bị xóa'], 404);
        }

        return response()->json(['deleted_users' => $deletedUsers], 200);
    }
    private function checkMail($email)
    {
        $originalEmail = $email;
        $count = 1;

        while (User::where('email', $email)->exists()) {
            $email = $originalEmail . "(Copy '$count')";
            $count++;
        }

        return $email;
    }
    public function duplicateUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Id user không tồn tại'], 404);
        }

        if ($user->role == 0) {
            return response()->json(['error' => 'Admin không được duplicate'], 403);
        }

        $newUser = $user->replicate();
        $newUser->name = $newUser->name . ' (Copy)';

        // Đổi tên email thành 'copy_' + tên email cũ
        $baseEmail = 'copy_' . $user->email;
        $newUser->email = $baseEmail;

        // Kiểm tra tính duy nhất của email
        $counter = 1;
        while (User::where('email', $newUser->email)->exists()) {
            // Thay đổi email thành 'counter_copy_email'
            $newUser->email = $counter . '_' . $baseEmail;
            $counter++;
        }

        $newUser->save();

        return response()->json(['message' => 'Thành công!', 'user' => $newUser], 201);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ], [
            'password.required' => 'Chưa nhập mật khẩu hiện tại',
            'new_password.required' => 'Chưa nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Mật khẩu hiện tại không chính xác'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Thay đổi mật khẩu thành công!'], 200);
    }
}
