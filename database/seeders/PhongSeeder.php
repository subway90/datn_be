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
            'hinh_anh' => 'room/img01.jpg;room/img02.jpg;room/img03.jpg;room/img04.jpg;room/img05.jpg',
            'dien_tich' => 30,
            'gac_lung' => true,
            'gia_thue' => 6000000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 1, // ID tòa nhà
            'ten_phong' => 'Phòng 102',
              'hinh_anh' => 'room/img02.jpg;room/img01.jpg;room/img03.jpg;room/img04.jpg;room/img05.jpg',
            'dien_tich' => 25,
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
              'hinh_anh' => 'room/img03.jpg;room/img02.jpg;room/img01.jpg;room/img04.jpg;room/img05.jpg',
            'dien_tich' => 26,
            'gac_lung' => true,
            'gia_thue' => 3200000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
        Phong::create([
            'toa_nha_id' => 2, // ID tòa nhà
            'ten_phong' => 'Phòng 104',
              'hinh_anh' => 'room/img05.jpg;room/img02.jpg;room/img01.jpg;room/img01.jpg;room/img05.jpg',
            'dien_tich' => 26,
            'gac_lung' => false,
            'gia_thue' => 3200000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
        Phong::create([
            'toa_nha_id' => 3, // ID tòa nhà
            'ten_phong' => 'Phòng 105',
              'hinh_anh' => 'room/img04.jpg;room/img02.jpg;room/img01.jpg;room/img01.jpg;room/img05.jpg',
            'dien_tich' => 30,
            'gac_lung' => true,
            'gia_thue' => 4500000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
        Phong::create([
            'toa_nha_id' => 4, // ID tòa nhà
            'ten_phong' => 'Phòng 106',
              'hinh_anh' => 'room/img05.jpg;room/img02.jpg;room/img01.jpg;room/img01.jpg;room/img01.jpg',
            'dien_tich' => 30,
            'gac_lung' => false,
            'gia_thue' => 1900000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
        Phong::create([
            'toa_nha_id' => 4, // ID tòa nhà
            'ten_phong' => 'Phòng 107',
              'hinh_anh' => 'room/img01.jpg;room/img02.jpg;room/img01.jpg;room/img01.jpg;room/img05.jpg',
            'dien_tich' => 21,
            'gac_lung' => true,
            'gia_thue' => 1900000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
        Phong::create([
            'toa_nha_id' => 4, // ID tòa nhà
            'ten_phong' => 'Phòng 108',
              'hinh_anh' => 'room/img03.jpg;room/img02.jpg;room/img01.jpg;room/img04.jpg;room/img05.jpg',
            'dien_tich' => 32,
            'gac_lung' => false,
            'gia_thue' => 2500000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 50000,
            'tien_ich' => 'Máy lạnh;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn',
            'trang_thai' => 1,
        ]);
    }
}
