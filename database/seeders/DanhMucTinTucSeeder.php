<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhMucTinTuc;

class DanhMucTinTucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 5 record mẫu
        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Phòng trọ',
            'slug' => 'phong-tro',
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Chia sẻ',
            'slug' => 'chia-se',
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Kiến thức',
            'slug' => 'kien-thuc',
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Mẹo vặt',
            'slug' => 'meo-vat',
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Đời sống',
            'slug' => 'doi-song',
        ]);
    }
}