<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KhuVuc;

class KhuVucSeeder extends Seeder
{
    public function run()
    {
        KhuVuc::create([
            'ten' => 'Quận 12',
            'slug' => 'quan-12',
            'image' => 'http://localhost:8000/storage/area/quan12.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Gò Vấp',
            'slug' => 'quan-go-vap',
            'image' => 'http://localhost:8000/storage/area/quangovap.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Hóc Môn',
            'slug' => 'quan-hoc-mon',
            'image' => 'http://localhost:8000/storage/area/quanhocmon.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Bình',
            'slug' => 'quan-tan-binh',
            'image' => 'http://localhost:8000/storage/area/quantanbinh.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Bình Tân',
            'slug' => 'quan-binh-tan',
            'image' => 'http://localhost:8000/storage/area/quanbinhtan.jpg',
        ]);

        KhuVuc::create([
            'ten' => 'Quận Phú Nhuận',
            'slug' => 'quan-phu-nhuan',
            'image' => 'http://localhost:8000/storage/area/quanphunhuan.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Phú',
            'slug' => 'quan-tan-phu',
            'image' => 'http://localhost:8000/storage/area/quantanphu.jpg',
            'noi_bat'=> 1,
        ]);
    }
}