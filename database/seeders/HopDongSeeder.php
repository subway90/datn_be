<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HopDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hop_dong')->insert([
            [
                'id_phong' => 1,
                'id_tai_khoan' => 2,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addMonths(6),
                'trang_thai' => 1,
                'gia_thue' => 5000000,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'id_phong' => 2,
                'id_tai_khoan' => 3,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addMonths(12),
                'trang_thai' => 1,
                'gia_thue' => 8000000,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'id_phong' => 3,
                'id_tai_khoan' => 4,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addMonths(12),
                'trang_thai' => 1,
                'gia_thue' => 8000000,
                'creat_at' => now(),
                'update_at' => now(),
            ]
        ]);
    }
}
