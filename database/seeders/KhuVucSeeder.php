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
            'image' => 'quan12.jpg',
            'thu_tu' => 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Gò Vấp',
            'slug' => 'quan-go-vap',
            'image' => 'quangovap.jpg',
            'thu_tu' => 2,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Hóc Môn',
            'slug' => 'quan-hoc-mon',
            'image' => 'quanhocmon.jpg',
            'thu_tu' => 3,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Bình',
            'slug' => 'quan-tan-binh',
            'image' => 'quantanbinh.jpg',
            'thu_tu' => 4,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Bình Tân',
            'slug' => 'quan-binh-tan',
            'image' => 'quanbinhtan.jpg',
            'thu_tu' => 5,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Phú Nhuận',
            'slug' => 'quan-phu-nhuan',
            'image' => 'quanphunhuan.jpg',
            'thu_tu' => 6,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Phú',
            'slug' => 'quan-tan-phu',
            'image' => 'quantanphu.jpg',
            'thu_tu' => 7,
        ]);
    }
}