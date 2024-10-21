<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThanhToan;

class ThanhToanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThanhToan::create([
            'hop_dong_id' => 1,
            'so_tien' => 3450000,
            'hinh_thuc' => 1, // chuyển khoản
            'ma_giao_dich' => 'VNPAY0001',
            'noi_dung' => 'Thanh toán tiền thuê trọ tháng 2',
            'trang_thai' => 1, // thành công
            'ngay_giao_dich' => '2024-02-01',
        ]);

        ThanhToan::create([
            'hop_dong_id' => 2,
            'code_uu_dai' => 'CODE100K',
            'so_tien' => 1850000,
            'hinh_thuc' => 2, // tiền mặt
            'ma_giao_dich' => 'COD0001',
            'trang_thai' => 1, // thành công
            'ngay_giao_dich' => '2024-02-16',
        ]);

        ThanhToan::create([
            'hop_dong_id' => 1,
            'so_tien' => 3000000,
            'hinh_thuc' => 1, // chuyển khoản
            'ma_giao_dich' => 'TRANS002',
            'trang_thai' => 0, // thất bại
            'ngay_giao_dich' => '2024-03-01',
        ]);
    }
}