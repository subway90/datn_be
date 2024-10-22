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
            'thu_tu' => 1,
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Chia sẻ',
            'slug' => 'chia-se',
            'thu_tu' => 2,
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Kiến thức',
            'slug' => 'kien-thuc',
            'thu_tu' => 3,
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Mẹo vặt',
            'slug' => 'meo-vat',
            'thu_tu' => 4,
        ]);

        DanhMucTinTuc::create([
            'ten_danh_muc' => 'Đời sống',
            'slug' => 'doi-song',
            'thu_tu' => 5,
        ]);
    }
}