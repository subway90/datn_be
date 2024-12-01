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
            'hinh_anh' => 'room/img06.jpg;room/img07.jpg;room/img08.jpg;room/img09.jpg;room/img10.jpg',
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
            'hinh_anh' => 'room/img11.jpg;room/img12.jpg;room/img13.jpg;room/img14.jpg;room/img15.jpg',
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
            'hinh_anh' => 'room/img16.jpg;room/img17.jpg;room/img18.jpg;room/img19.jpg;room/img20.jpg',
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
            'hinh_anh' => 'room/img21.jpg;room/img22.jpg;room/img23.jpg;room/img24.jpg;room/img25.jpg',
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
            'hinh_anh' => 'room/img26.jpg;room/img27.jpg;room/img28.jpg;room/img29.jpg;room/img30.jpg',
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
            'hinh_anh' => 'room/img31.jpg;room/img32.jpg;room/img33.jpg;room/img34.jpg;room/img35.jpg',
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
            'hinh_anh' => 'room/img36.jpg;room/img37.jpg;room/img38.jpg;room/img39.jpg;room/img40.jpg',
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

        Phong::create([
            'toa_nha_id' => 1,
            'ten_phong' => 'Phòng 201',
            'hinh_anh' => 'room/img41.jpg;room/img42.jpg;room/img43.jpg;room/img44.jpg;room/img45.jpg',
            'dien_tich' => 25,
            'gac_lung' => false,
            'gia_thue' => 3000000,
            'don_gia_dien' => 3500,
            'don_gia_nuoc' => 2500,
            'tien_xe_may' => 120000,
            'phi_dich_vu' => 70000,
            'tien_ich' => 'Máy lạnh;Wifi;Máy giặt',
            'noi_that' => 'Giường;Tủ;Bàn;Kệ sách',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 2,
            'ten_phong' => 'Phòng 202',
            'hinh_anh' => 'room/img46.jpg;room/img47.jpg;room/img48.jpg;room/img49.jpg;room/img50.jpg',
            'dien_tich' => 28,
            'gac_lung' => true,
            'gia_thue' => 3500000,
            'don_gia_dien' => 4000,
            'don_gia_nuoc' => 3000,
            'tien_xe_may' => 150000,
            'phi_dich_vu' => 60000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera',
            'noi_that' => 'Giường;Bàn;Kệ bếp',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 3,
            'ten_phong' => 'Phòng 203',
            'hinh_anh' => 'room/img51.jpg;room/img52.jpg;room/img53.jpg;room/img54.jpg;room/img55.jpg',
            'dien_tich' => 20,
            'gac_lung' => false,
            'gia_thue' => 2000000,
            'don_gia_dien' => 3000,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 80000,
            'phi_dich_vu' => 40000,
            'tien_ich' => 'Máy lạnh;Nước nóng',
            'noi_that' => 'Giường;Tủ quần áo',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 4,
            'ten_phong' => 'Phòng 204',
            'hinh_anh' => 'room/img56.jpg;room/img57.jpg;room/img58.jpg;room/img59.jpg;room/img60.jpg',
            'dien_tich' => 35,
            'gac_lung' => true,
            'gia_thue' => 4500000,
            'don_gia_dien' => 4500,
            'don_gia_nuoc' => 3500,
            'tien_xe_may' => 150000,
            'phi_dich_vu' => 80000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera;Máy giặt',
            'noi_that' => 'Giường;Tủ;Kệ sách;Bếp',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 5,
            'ten_phong' => 'Phòng 301',
            'hinh_anh' => 'room/img61.jpg;room/img62.jpg;room/img63.jpg;room/img64.jpg;room/img65.jpg',
            'dien_tich' => 30,
            'gac_lung' => false,
            'gia_thue' => 3200000,
            'don_gia_dien' => 3200,
            'don_gia_nuoc' => 2500,
            'tien_xe_may' => 100000,
            'phi_dich_vu' => 70000,
            'tien_ich' => 'Wifi;Camera',
            'noi_that' => 'Bàn;Ghế;Tủ quần áo',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 4,
            'ten_phong' => 'Phòng 302',
            'hinh_anh' => 'room/img66.jpg;room/img67.jpg;room/img68.jpg;room/img69.jpg;room/img70.jpg',
            'dien_tich' => 40,
            'gac_lung' => true,
            'gia_thue' => 5000000,
            'don_gia_dien' => 4000,
            'don_gia_nuoc' => 3000,
            'tien_xe_may' => 180000,
            'phi_dich_vu' => 90000,
            'tien_ich' => 'Máy lạnh;Nước nóng;Wifi',
            'noi_that' => 'Giường;Tủ;Bàn;Kệ bếp;Bếp',
            'trang_thai' => 0, // Đã thuê
        ]);

        Phong::create([
            'toa_nha_id' => 3,
            'ten_phong' => 'Phòng 303',
            'hinh_anh' => 'room/img71.jpg;room/img72.jpg;room/img73.jpg;room/img74.jpg;room/img75.jpg',
            'dien_tich' => 22,
            'gac_lung' => false,
            'gia_thue' => 2800000,
            'don_gia_dien' => 3200,
            'don_gia_nuoc' => 2000,
            'tien_xe_may' => 120000,
            'phi_dich_vu' => 60000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera',
            'noi_that' => 'Giường;Tủ quần áo',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 2,
            'ten_phong' => 'Phòng 304',
            'hinh_anh' => 'room/img76.jpg;room/img77.jpg;room/img78.jpg;room/img79.jpg;room/img80.jpg',
            'dien_tich' => 36,
            'gac_lung' => true,
            'gia_thue' => 4800000,
            'don_gia_dien' => 4500,
            'don_gia_nuoc' => 3500,
            'tien_xe_may' => 150000,
            'phi_dich_vu' => 85000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera;Nước nóng',
            'noi_that' => 'Giường;Tủ;Bàn;Kệ sách',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 1,
            'ten_phong' => 'Phòng 305',
            'hinh_anh' => 'room/img81.jpg;room/img82.jpg;room/img83.jpg;room/img84.jpg;room/img85.jpg',
            'dien_tich' => 38,
            'gac_lung' => true,
            'gia_thue' => 5000000,
            'don_gia_dien' => 4500,
            'don_gia_nuoc' => 3500,
            'tien_xe_may' => 150000,
            'phi_dich_vu' => 90000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera;Nước nóng',
            'noi_that' => 'Giường;Tủ;Bàn;Kệ sách;Sofa',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 5,
            'ten_phong' => 'Phòng 306',
            'hinh_anh' => 'room/img86.jpg;room/img87.jpg;room/img88.jpg;room/img89.jpg;room/img90.jpg',
            'dien_tich' => 30,
            'gac_lung' => false,
            'gia_thue' => 4200000,
            'don_gia_dien' => 4000,
            'don_gia_nuoc' => 3000,
            'tien_xe_may' => 130000,
            'phi_dich_vu' => 80000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera',
            'noi_that' => 'Giường;Tủ quần áo;Bàn làm việc',
            'trang_thai' => 0, // Đã thuê
        ]);

        Phong::create([
            'toa_nha_id' => 4,
            'ten_phong' => 'Phòng 307',
            'hinh_anh' => 'room/img91.jpg;room/img92.jpg;room/img93.jpg;room/img94.jpg;room/img95.jpg',
            'dien_tich' => 42,
            'gac_lung' => true,
            'gia_thue' => 5200000,
            'don_gia_dien' => 4600,
            'don_gia_nuoc' => 3500,
            'tien_xe_may' => 160000,
            'phi_dich_vu' => 95000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera;Nước nóng;Ban công',
            'noi_that' => 'Giường;Tủ;Bàn ăn;Kệ bếp',
            'trang_thai' => 1,
        ]);

        Phong::create([
            'toa_nha_id' => 3,
            'ten_phong' => 'Phòng 308',
            'hinh_anh' => 'room/img96.jpg;room/img97.jpg;room/img98.jpg;room/img99.jpg;room/img100.jpg',
            'dien_tich' => 34,
            'gac_lung' => false,
            'gia_thue' => 4600000,
            'don_gia_dien' => 4200,
            'don_gia_nuoc' => 3300,
            'tien_xe_may' => 140000,
            'phi_dich_vu' => 85000,
            'tien_ich' => 'Máy lạnh;Wifi;Camera;Ban công',
            'noi_that' => 'Giường;Tủ quần áo;Bàn;Tivi',
            'trang_thai' => 1,
        ]);
    }
}
