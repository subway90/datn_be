<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BinhLuanTinTuc;

class BinhLuanTinTucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo từng record bình luận riêng cho các bài viết
        BinhLuanTinTuc::create([
            'tai_khoan_id' => 1,
            'tin_tuc_id' => 1,
            'noi_dung' => 'Bình luận 1 cho bài viết ID 1.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 2,
            'tin_tuc_id' => 1,
            'noi_dung' => 'Bình luận 2 cho bài viết ID 1.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 4,
            'tin_tuc_id' => 1,
            'noi_dung' => 'Bình luận 3 cho bài viết ID 1.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 2,
            'tin_tuc_id' => 2,
            'noi_dung' => 'Bình luận 1 cho bài viết ID 2.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 4,
            'tin_tuc_id' => 2,
            'noi_dung' => 'Bình luận 2 cho bài viết ID 2.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 3,
            'tin_tuc_id' => 2,
            'noi_dung' => 'Bình luận 3 cho bài viết ID 2.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 1,
            'tin_tuc_id' => 3,
            'noi_dung' => 'Bình luận 1 cho bài viết ID 3.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 2,
            'tin_tuc_id' => 3,
            'noi_dung' => 'Bình luận 2 cho bài viết ID 3.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 3,
            'tin_tuc_id' => 3,
            'noi_dung' => 'Bình luận 3 cho bài viết ID 3.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 2,
            'tin_tuc_id' => 4,
            'noi_dung' => 'Bình luận 1 cho bài viết ID 4.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 3,
            'tin_tuc_id' => 4,
            'noi_dung' => 'Bình luận 2 cho bài viết ID 4.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 4,
            'tin_tuc_id' => 4,
            'noi_dung' => 'Bình luận 3 cho bài viết ID 4.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 1,
            'tin_tuc_id' => 5,
            'noi_dung' => 'Bình luận 1 cho bài viết ID 5.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 3,
            'tin_tuc_id' => 5,
            'noi_dung' => 'Bình luận 2 cho bài viết ID 5.',
        ]);

        BinhLuanTinTuc::create([
            'tai_khoan_id' => 4,
            'tin_tuc_id' => 5,
            'noi_dung' => 'Bình luận 3 cho bài viết ID 5.',
        ]);
    }
}