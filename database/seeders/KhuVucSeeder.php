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
            'image' => 'area/quan12.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Gò Vấp',
            'slug' => 'quan-go-vap',
            'image' => 'area/quangovap.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Hóc Môn',
            'slug' => 'quan-hoc-mon',
            'image' => 'area/quanhocmon.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Bình',
            'slug' => 'quan-tan-binh',
            'image' => 'area/quantanbinh.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Bình Tân',
            'slug' => 'quan-binh-tan',
            'image' => 'area/quanbinhtan.jpg',
        ]);

        KhuVuc::create([
            'ten' => 'Quận Phú Nhuận',
            'slug' => 'quan-phu-nhuan',
            'image' => 'area/quanphunhuan.jpg',
            'noi_bat'=> 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Phú',
            'slug' => 'quan-tan-phu',
            'image' => 'area/quantanphu.jpg',
            'noi_bat'=> 1,
        ]);
    }
}