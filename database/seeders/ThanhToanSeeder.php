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
            'hoa_don_id' => 1,
            'hinh_thuc' => 1,
            'ma_giao_dich' => 'VNPAY0001',
            'ngay_giao_dich' => '2024-01-05',
            'so_tien' => 4822500,
            'noi_dung' => 'Đóng tiền thuê nhà tháng 1 | phòng 101 | 165-9 Phan Văn Hớn',
            'trang_thai' => 1, // thành công
        ]);

    }
}