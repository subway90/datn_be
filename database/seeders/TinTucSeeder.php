<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TinTuc;

class TinTucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 5 record mẫu cho bảng tin_tuc
        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 1, // ID danh mục 1
            'tieu_de' => 'Tin Thể Thao 1',
            'slug' => 'tin-the-thao-1',
            'image' => 'image1.jpg',
            'noi_dung' => 'Nội dung cho tin thể thao 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 2, // ID danh mục 2
            'tieu_de' => 'Tin Công Nghệ 1',
            'slug' => 'tin-cong-nghe-1',
            'image' => 'image2.jpg',
            'noi_dung' => 'Nội dung cho tin công nghệ 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 3, // ID danh mục 3
            'tieu_de' => 'Tin Giải Trí 1',
            'slug' => 'tin-giai-tri-1',
            'image' => 'image3.jpg',
            'noi_dung' => 'Nội dung cho tin giải trí 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 4, // ID danh mục 4
            'tieu_de' => 'Tin Xã Hội 1',
            'slug' => 'tin-xa-hoi-1',
            'image' => 'image4.jpg',
            'noi_dung' => 'Nội dung cho tin xã hội 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 5, // ID danh mục 5
            'tieu_de' => 'Tin Giáo Dục 1',
            'slug' => 'tin-giao-duc-1',
            'image' => 'image5.jpg',
            'noi_dung' => 'Nội dung cho tin giáo dục 1.',
        ]);
    }
}
