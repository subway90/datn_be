<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaUuDaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ma_uu_dai')->insert([
            [
                'code' => 'ma_giam_gia_10',
                'mo_ta' => 'Giảm giá 10%',
                'so_luong' => 20,
                'trang_thai' => 1,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'code' => 'ma_giam_gia_20',
                'mo_ta' => 'Giảm giá 20%',
                'so_luong' => 10,
                'trang_thai' => 1,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'code' => 'ma_giam_gia_30',
                'mo_ta' => 'Giảm giá 30%',
                'so_luong' => 5,
                'trang_thai' => 1,
                'creat_at' => now(),
                'update_at' => now(),
            ]
        ]);
    }
}
