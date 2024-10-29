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
            'image' => 'building/img01.jpg;building/img02.jpg;building/img03.jpg;building/img04.jpg;building/img05.jpg',
            'gia_thue' => 3500000,
            'dien_tich' => 24,
            'mo_ta' => 'Giá từ 3 triệu 5, diện tích từ 24 m² trở lên, nhiều tiện ích. ',
            'vi_tri' => 'Bách Hóa Xanh 500m;trạm xá phường Tân Thới Nhất 700m;trường THPT An Lạc 900m; siêu thị CoopMart 1km; bến xe An Sương 2.7km',
            'tien_ich' => 'Thang máy;Thang bộ;Bảo vệ an ninh 24/7; Khu giặt giũ trên sân thượng; Camera an ninh; Cổng tòa nhà mở khóa bằng vân tay; Giờ giấc tự do; Cho nuôi thú cưng',
            'luot_xem' => 112,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 622/14 đường Cộng Hòa',
            'slug' => 'so-622-14-duong-cong-hoa',
            'image' => 'building/img01.jpg;building/img02.jpg;building/img03.jpg;building/img04.jpg;building/img05.jpg',
            'gia_thue' => 2500000,
            'dien_tich' => 12,
            'mo_ta' => 'Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'điểm chợ Nhất Chi Mai 480m;Bách Hóa Xanh 850m;đường Cộng Hòa 890m;đường Quang Trung 6.2km',
            'tien_ich' => 'Thang máy;Thang bộ;Bảo vệ an ninh 24/7; Khu giặt giũ trên sân thượng; Camera an ninh; Tạp hóa dưới sảnh',
            'noi_bat' => 1,
            'luot_xem' => 247,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 30 Nhất Chi Mai',
            'slug' => 'so-30-nhat-chi-mai',
            'image' => 'building/img01.jpg;building/img02.jpg;building/img03.jpg;building/img04.jpg;building/img05.jpg',
            'gia_thue' => 4000000,
            'dien_tich' => 15,
            'mo_ta' => 'Khu vực an ninh, nhiều tiện ích dịch vụ.Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'điểm chợ Nhất Chi Mai 280m;Bách Hóa Xanh 350m;Cửa hàng Circle K 450m; Bệnh viện 500m;đường Cộng Hòa 680m;đường Quang Trung 3.2km',
            'tien_ich' => 'Thang máy;Thang bộ;Bảo vệ an ninh 24/7; Khu giặt giũ trên sân thượng; Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 1102,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 1,
            'ten' => 'Số 228 Lê Văn Khương',
            'slug' => 'so-228-le-van-khuong',
            'image' => 'building/img01.jpg;building/img02.jpg;building/img03.jpg;building/img04.jpg;building/img05.jpg',
            'gia_thue' => 1500000,
            'dien_tich' => 9,
            'mo_ta' => 'Nằm trên đường Lê Văn Khương với nhiều tiện ích, khu vui chơi, dịch vụ công cộng. Là nơi tập trung nhiều khu công nghiệ (KCN) ví dụ nhà máy bia Heineken, nhà máy bia Sài Gòn, xưởng sản xuất bánh ô tô Trường Hải',
            'vi_tri' => 'Quốc lộ 1A 500m;đại học HUFI 1km; đại học HUFLIT 2km; công viên Phần mềm Quang Trung 4.2km',
            'tien_ich' => 'Thang bộ;Bảo vệ an ninh 24/7;Khu giặt giũ trên sân thượng;Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 453,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 5,
            'ten' => '12/8 đường CMT8',
            'slug' => '12-8-duong-cmt-8',
            'image' => 'building/img01.jpg;building/img02.jpg;building/img03.jpg;building/img04.jpg;building/img05.jpg',
            'gia_thue' => 2750000,
            'dien_tich' => 15,
            'mo_ta' => 'Nằm trung tâm thành phố, với nhiều tiện ích và nhiều vị trí thuận tiện',
            'vi_tri' => 'bệnh viện chợ Rẫy 1km; đường Trường Chinh 1.5km; chợ Tân Bình 2.2 km; trung tâm quận 1 2.5km',
            'tien_ich' => 'Thang bộ;Khu giặt giũ trên sân thượng;Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 552,
        ]);
    }
}