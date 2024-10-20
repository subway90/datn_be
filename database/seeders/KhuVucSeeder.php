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
            'thu_tu' => 1,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Gò Vấp',
            'slug' => 'quan-go-vap',
            'thu_tu' => 2,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Hóc Môn',
            'slug' => 'quan-hoc-mon',
            'thu_tu' => 3,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Bình',
            'slug' => 'quan-tan-binh',
            'thu_tu' => 4,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Bình Tân',
            'slug' => 'quan-binh-tan',
            'thu_tu' => 5,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Phú Nhuận',
            'slug' => 'quan-phu-nhuan',
            'thu_tu' => 6,
        ]);

        KhuVuc::create([
            'ten' => 'Quận Tân Phú',
            'slug' => 'quan-tan-phu',
            'thu_tu' => 7,
        ]);
    }
}