<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'image' => 'banner/banner01.jpg',
            'title' => null,
            'content' => null,
            'order' => 1,
            'status' => 1,
        ]);

        Banner::create([
            'image' => 'banner/banner02.jpg',
            'title' => 'Tìm trọ ở Hồ Chí Minh',
            'content' => 'Hơn 2,000 phòng trọ với giá từ 2 triệu VNĐ',
            'order' => 2,
            'status' => 1,
        ]);

        Banner::create([
            'image' => 'banner/banner03.jpg',
            'title' => null,
            'content' => null,
            'order' => null,
            'status' => 1,
        ]);
    }
}