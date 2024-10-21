<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThanhToanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('thanh_toan')->insert([
            [
                'token' => 'abc123',
                'id_hop_dong' => 1,
                'code' => 123456,
                'so_tien' => 1000000,
                'hinh_thuc' => 1, // chuyển khoản
                'ma_giao_dich' => 'TRANS001',
                'trang_thai' => 1,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'token' => 'def456',
                'id_hop_dong' => 2,
                'code' => 654321,
                'so_tien' => 2000000,
                'hinh_thuc' => 2, // tiền mặt
                'ma_giao_dich' => 'TRANS002',
                'trang_thai' => 0,
                'creat_at' => now(),
                'update_at' => now(),
            ],
            [
                'token' => 'ghi789',
                'id_hop_dong' => 3,
                'code' => 654321,
                'so_tien' => 3000000,
                'hinh_thuc' => 2, // tiền mặt
                'ma_giao_dich' => 'TRANS003',
                'trang_thai' => 0,
                'creat_at' => now(),
                'update_at' => now(),
            ]
        ]);
    }
}
