<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HopDong;

class HopDongSeeder extends Seeder
{
    public function run()
    {
        HopDong::create([
            'phong_id' => 1,
            'tai_khoan_id' => 3,
            'ngay_bat_dau' => '2023-01-01',
            'ngay_ket_thuc' => '2024-06-01',
            'gia_thue' => 3250000,
        ]);

        HopDong::create([
            'phong_id' => 1,
            'tai_khoan_id' => 2,
            'ngay_bat_dau' => '2024-01-01',
            'ngay_ket_thuc' => '2024-12-31',
            'gia_thue' => 3450000,
        ]);

        HopDong::create([
            'phong_id' => 2,
            'tai_khoan_id' => 3,
            'ngay_bat_dau' => '2024-02-01',
            'ngay_ket_thuc' => '2025-01-31',
            'gia_thue' => 1950000,
        ]);

        HopDong::create([
            'phong_id' => 3,
            'tai_khoan_id' => 4,
            'ngay_bat_dau' => '2024-03-01',
            'ngay_ket_thuc' => '2024-09-02',
            'gia_thue' => 3550000,
        ]);

        HopDong::create([
            'phong_id' => 4,
            'tai_khoan_id' => 4,
            'ngay_bat_dau' => '2024-10-12',
            'ngay_ket_thuc' => '2025-10-12',
            'gia_thue' => 2450000,
        ]);
    }
}