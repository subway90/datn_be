<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TienIchToaNha;

class TienIchToaNhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TienIchToaNha::create([
            'name' => 'Mạng wifi',
        ]);

        TienIchToaNha::create([
            'name' => 'Thang máy',
        ]);

        TienIchToaNha::create([
            'name' => 'Thang bộ',
        ]);

        TienIchToaNha::create([
            'name' => 'Bảo vệ an ninh 24/7',
        ]);

        TienIchToaNha::create([
            'name' => 'Khu giặt giũ công cộng',
        ]);

        TienIchToaNha::create([
            'name' => 'Camera an ninh',
        ]);

        TienIchToaNha::create([
            'name' => 'Mở khóa cổng vân tay',
        ]);
        TienIchToaNha::create([
            'name' => 'Giờ giấc tự do',
        ]);

        TienIchToaNha::create([
            'name' => 'Cho nuôi thú cưng',
        ]);
    }
}
