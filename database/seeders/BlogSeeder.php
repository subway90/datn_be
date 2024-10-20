<?php

namespace Database\Seeders;

use App\Models\Binh_luan_tin_tuc;
use App\Models\Danh_muc_tin_tuc;
use App\Models\Tin_tuc;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Tin_tuc::created(
            [
                'id_tai_khoan' => '1',
                'id_danh_muc' => '1'
            ],
        );
        Danh_muc_tin_tuc::created(
            [
                'ten_danh_muc' => 'Nhà trọ 1',
                'trang_thai' => 'con trong'
            ]
        );
        Binh_luan_tin_tuc::created(
            [
                'id_tai_khoan' => '1',
                'id_bai-viet' => '1',
                'noi_dung' => 'My house so pretty',
                'trang_thai' => 'con trong',
            ]
        );
    }
}

