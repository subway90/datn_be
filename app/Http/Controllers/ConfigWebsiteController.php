<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ConfigWebsite;

class ConfigWebsiteController extends Controller
{
    public function edit(Request $request, $id)
    {
        // 1. Kiểm tra xem bản ghi có tồn tại hay không
        $config = ConfigWebsite::find($id);
        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin cấu hình với ID: ' . $id,
            ], 404);
        }

        // 2. Xác thực dữ liệu đầu vào với thông báo lỗi tiếng Việt
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'favicon' => 'nullable|file|mimes:png,jpg,jpeg,ico|max:2048',
            'logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ], [
            'name.required' => 'Tên cấu hình không được để trống',
            'name.string' => 'Tên cấu hình phải là một chuỗi ký tự',
            'name.max' => 'Tên cấu hình không được vượt quá 255 ký tự',
            'description.required' => 'Mô tả không được để trống',
            'description.string' => 'Mô tả phải là một chuỗi ký tự',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự',
            'phone.regex' => 'Số điện thoại phải bao gồm 10 chữ số',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email phải có định dạng hợp lệ',
            'email.max' => 'Email không được vượt quá 255 ký tự',
            'address.required' => 'Địa chỉ không được để trống',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự',
            'favicon.file' => 'Favicon phải là một file hợp lệ',
            'favicon.mimes' => 'Favicon phải là file có định dạng png, jpg, jpeg, hoặc ico',
            'favicon.max' => 'Dung lượng favicon không được vượt quá 2MB',
            'logo.file' => 'Logo phải là một file hợp lệ',
            'logo.mimes' => 'Logo phải là file có định dạng png, jpg, hoặc jpeg',
            'logo.max' => 'Dung lượng logo không được vượt quá 2MB',
        ]);

        // 3. Bắt lỗi và trả về thông báo
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ], 400);
        }

        // 4. Xử lý upload file (favicon và logo)
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('public/system');
            $config->favicon = str_replace('public/', 'storage/', $faviconPath);
        }

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/system');
            $config->logo = str_replace('public/', 'storage/', $logoPath);
        }

        // 5. Cập nhật các thông tin khác
        $config->name = $request->input('name');
        $config->description = $request->input('description');
        $config->phone = $request->input('phone');
        $config->email = $request->input('email');
        $config->address = $request->input('address');

        // 6. Lưu vào cơ sở dữ liệu
        $config->save();

        // 7. Trả về JSON response
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin cấu hình thành công!',
            'data' => $config,
        ]);
    }
    public function getall(){
        $getall = ConfigWebsite::all();
        return [
            'getall'=>$getall,
        ];
    }
}
