<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HoaDon;
use Ramsey\Uuid\Uuid;

class HoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 2,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 10',
            'hinh_thuc' => 0,  // thanh toán tiền mặt
            'trang_thai' => 1, // đã thanh toán
            'created_at' => '2024-10-29 12:55:32',
            'updated_at' => '2024-10-29 12:55:32',
        ]);

        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 2,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 11',
            'trang_thai' => 0, //chưa thanh toán
            'created_at' => '2024-11-29 12:55:32',
        ]);

        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 3,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 10',
            'hinh_thuc' => 1,  // thanh toán VNPAY
            'trang_thai' => 1, // đã thanh toán
            'created_at' => '2024-10-17 12:55:32',
            'updated_at' => '2024-10-17 12:55:32',
        ]);

        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 3,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 10',
            'hinh_thuc' => 1,  // thanh toán VNPAY
            'trang_thai' => 1, // đã thanh toán
            'created_at' => '2024-11-17 12:55:32',
            'updated_at' => '2024-11-17 12:55:32',
        ]);

        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 3,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 12',
            'trang_thai' => 0, //chưa thanh toán
            'created_at' => '2024-11-17 12:55:32',
        ]);

        HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => 5,
            'tien_thue' => 4500000,
            'tien_dien' => 3500,
            'so_ki_dien' => 15,
            'tien_nuoc' => 0,
            'so_khoi_nuoc' => 0,
            'tien_xe' => 120000*1,
            'so_luong_xe' => 1,
            'tien_dich_vu' => 150000,
            'so_luong_nguoi' => 1,
            'noi_dung' => 'Thanh toán tiền nhà tháng 12',
            'trang_thai' => 0, //chưa thanh toán
            'created_at' => '2024-11-29 07:33:44',
        ]);



    }
}