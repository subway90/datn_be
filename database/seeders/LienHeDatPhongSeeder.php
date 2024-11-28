<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LienHeDatPhong;
use App\Models\Phong;
use App\Models\User;
use Faker\Factory as Faker;

class LienHeDatPhongSeeder extends Seeder
{
    public function run()
    {
        LienHeDatPhong::create([
            'phong_id' => 1,
            'tai_khoan_id' => 2,
            'ho_ten' => 'Lê Thị Ân',
            'so_dien_thoai' => '0894662551',
            'noi_dung' => null,
        ]);

        LienHeDatPhong::create([
            'phong_id' => 2,
            'tai_khoan_id' => 2,
            'ho_ten' => 'Nguyễn Hoài An',
            'so_dien_thoai' => '0777655432',
            'noi_dung' => null,
            'trang_thai' => 1,
        ]);

        LienHeDatPhong::create([
            'phong_id' => 1,
            'tai_khoan_id' => 3,
            'ho_ten' => 'Lê Thanh Phong',
            'so_dien_thoai' => '0989655499',
            'noi_dung' => null,
            'trang_thai' => 1,
        ]);

        LienHeDatPhong::create([
            'phong_id' => 1,
            'tai_khoan_id' => 4,
            'ho_ten' => 'Test Họ Tên',
            'so_dien_thoai' => '0826542448',
            'noi_dung' => 'Em muon thue phong',
            'trang_thai' => 1,
        ]);
    }

}