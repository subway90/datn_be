<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToaNha;

class ToaNhaSeeder extends Seeder
{
    public function run()
    {
        ToaNha::create(attributes: [
            'khu_vuc_id' => 1,
            'ten' => 'Số 165/9 Phan Văn Hớn',
            'slug' => 'so-165-9-phan-van-hon',
            'image' => 'toa_nha_01.jpg;toa_nha_02.jpg;toa_nha_03.jpgtoa_nha_04.jpg;toa_nha_05.jpg',
            'gia_thue' => 2500000,
            'dien_tich' => 24,
            'mo_ta' => 'Giá từ 04 triệu, diện tích từ 12 - 24 m², trang bị 11/14 tiện ích. Khu trọ là một không gian sống an ninh, yên tĩnh, văn minh, tiện nghi và hiện đại. Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'Bách Hóa Xanh 450m;điểm chợ Nhất Chi Mai 680m;đường Cộng Hòa 980m;đường Quang Trung 1.2km',
            'tien_ich' => '2;3;4;5;6;7',
            'luot_xem' => 112,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 622/14 đường Cộng Hòa',
            'slug' => 'so-622-14-duong-cong-hoa',
            'image' => 'toa_nha_01.jpg;toa_nha_02.jpg;toa_nha_03.jpgtoa_nha_04.jpg;toa_nha_05.jpg',
            'gia_thue' => 3700000,
            'dien_tich' => 20,
            'mo_ta' => 'Giá từ 04 triệu, diện tích từ 12 - 24 m², trang bị 11/14 tiện ích. Khu trọ là một không gian sống an ninh, yên tĩnh, văn minh, tiện nghi và hiện đại. Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'Bách Hóa Xanh 750m;điểm chợ Nhất Chi Mai 480m;đường Cộng Hòa 890m;đường Quang Trung 6.2km',
            'tien_ich' => '1;2;6;7',
            'noi_bat' => 1,
            'luot_xem' => 247,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 30 Nhất Chi Mai',
            'slug' => 'so-30-nhat-chi-mai',
            'image' => 'toa_nha_01.jpg;toa_nha_02.jpg;toa_nha_03.jpgtoa_nha_04.jpg;toa_nha_05.jpg',
            'gia_thue' => 1800000,
            'dien_tich' => 15,
            'mo_ta' => 'Giá từ 04 triệu, diện tích từ 12 - 24 m², trang bị 11/14 tiện ích. Khu trọ là một không gian sống an ninh, yên tĩnh, văn minh, tiện nghi và hiện đại. Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'Bách Hóa Xanh 950m;điểm chợ Nhất Chi Mai 280m;đường Cộng Hòa 680m;đường Quang Trung 3.2km',
            'tien_ich' => '1;2;5;6;7',
            'luot_xem' => 1102,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 1,
            'ten' => 'Số 228 Lê Văn Khương',
            'slug' => 'so-228-le-van-khuong',
            'image' => 'toa_nha_01.jpg;toa_nha_02.jpg;toa_nha_03.jpgtoa_nha_04.jpg;toa_nha_05.jpg',
            'gia_thue' => 4500000,
            'dien_tich' => 27,
            'mo_ta' => 'Giá từ 04 triệu, diện tích từ 12 - 24 m², trang bị 11/14 tiện ích. Khu trọ là một không gian sống an ninh, yên tĩnh, văn minh, tiện nghi và hiện đại. Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'Bách Hóa Xanh 230m;điểm chợ Nhất Chi Mai 180m;đường Cộng Hòa 280m;đường Quang Trung 2.2km',
            'tien_ich' => '1;2;3;4',
            'luot_xem' => 453,
        ]);
    }
}