<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phong;

class PhongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Phong::create([
            'toa_nha_id' => 1, // ID tòa nhà
            'ten_phong' => 'Phòng 101',
            'hinh_anh' => 'image-01.jpg;image-02.jpg;image-03.jpg;image-04.jpg;image-05.jpg',
            'dien_tich' => 30,
            'gac_lung' => true,
            'gia_thue' => 3000000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh, Wifi',
            'noi_that' => 'Giường, Tủ',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 2, // ID tòa nhà
            'ten_phong' => 'Phòng 102',
            'hinh_anh' => 'image-01.jpg;image-02.jpg;image-03.jpg;image-04.jpg;image-05.jpg',
            'dien_tich' => 28,
            'gac_lung' => false,
            'gia_thue' => 2800000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh',
            'noi_that' => 'Giường',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 2, // ID tòa nhà
            'ten_phong' => 'Phòng 103',
            'hinh_anh' => 'image-01.jpg;image-02.jpg;image-03.jpg;image-04.jpg;image-05.jpg',
            'dien_tich' => 32,
            'gac_lung' => true,
            'gia_thue' => 3200000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh, Wifi',
            'noi_that' => 'Giường, Tủ, Bàn',
            'trang_thai' => 1,
        ]);
    }
}
