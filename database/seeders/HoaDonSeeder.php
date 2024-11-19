<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HoaDon;

class HoaDonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HoaDon::create([
            'hop_dong_id' => 2,
            'hinh_thuc' => 1, // chuyển khoản
            'tien_thue' => 4500000,
            'tien_dien' => 3500*15,
            'tien_nuoc' => 0*0,
            'tien_xe' => 120000*1,
            'tien_dich_vu' => 150000,
            'noi_dung' => 'Thanh toán tiền thuê trọ tháng 1 | Tiền thuê + Tiền điện + Tiền xe máy + 150K Tiền dịch vụ',
            'trang_thai' => 1, // thành công
        ]);

    }
}