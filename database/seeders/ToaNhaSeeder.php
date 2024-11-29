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
            'image' => 'building/img',
            'mo_ta' => 'Giá từ 3 triệu 5, diện tích từ 24 m² trở lên, nhiều tiện ích. ',
            'vi_tri' => 'Bách Hóa Xanh 500m;trạm xá phường Tân Thới Nhất 700m;trường THPT An Lạc 900m; siêu thị CoopMart 1km; bến xe An Sương 2.7km',
            'tien_ich' => 'Thang máy;Thang bộ;Bảo vệ an ninh 24/7; Khu giặt giũ trên sân thượng; Camera an ninh; Cổng tòa nhà mở khóa bằng vân tay; Giờ giấc tự do; Cho nuôi thú cưng',
            'luot_xem' => 112,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 622/14 đường Cộng Hòa',
            'slug' => 'so-622-14-duong-cong-hoa',
            'image' => 'building/img',
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
            'image' => 'building/img',
            'mo_ta' => 'Khu vực an ninh, nhiều tiện ích dịch vụ.Vị trí thuận tiện di chuyển đến Sân bay Tân Sơn Nhất, đường Cộng Hòa, đường Trường Chinh di chuyển dễ dàng sang những quận lân cận như Quận Tân Bình, Quận 12, Quận 3.',
            'vi_tri' => 'điểm chợ Nhất Chi Mai 280m;Bách Hóa Xanh 350m;Cửa hàng Circle K 450m; Bệnh viện 500m;đường Cộng Hòa 680m;đường Quang Trung 3.2km',
            'tien_ich' => 'Thang máy;Thang bộ;Bảo vệ an ninh 24/7; Khu giặt giũ trên sân thượng; Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 1102,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 1,
            'ten' => 'Số 228 Lê Văn Khương',
            'slug' => 'so-228-le-van-khuong',
            'image' => 'building/img',
            'mo_ta' => 'Nằm trên đường Lê Văn Khương với nhiều tiện ích, khu vui chơi, dịch vụ công cộng. Là nơi tập trung nhiều khu công nghiệ (KCN) ví dụ nhà máy bia Heineken, nhà máy bia Sài Gòn, xưởng sản xuất bánh ô tô Trường Hải',
            'vi_tri' => 'Quốc lộ 1A 500m;đại học HUFI 1km; đại học HUFLIT 2km; công viên Phần mềm Quang Trung 4.2km',
            'tien_ich' => 'Thang bộ;Bảo vệ an ninh 24/7;Khu giặt giũ trên sân thượng;Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 453,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 5,
            'ten' => '12/8 đường CMT8',
            'slug' => '12-8-duong-cmt-8',
            'image' => 'building/img',
            'mo_ta' => 'Nằm trung tâm thành phố, với nhiều tiện ích và nhiều vị trí thuận tiện',
            'vi_tri' => 'bệnh viện chợ Rẫy 1km; đường Trường Chinh 1.5km; chợ Tân Bình 2.2 km; trung tâm quận 1 2.5km',
            'tien_ich' => 'Thang bộ;Khu giặt giũ trên sân thượng;Camera an ninh;Cổng tòa nhà mở khóa bằng vân tay',
            'luot_xem' => 552,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 2,
            'ten' => 'Số 78/4 Nguyễn Văn Linh',
            'slug' => 'so-78-4-nguyen-van-linh',
            'image' => 'building/img',
            'mo_ta' => 'Khu vực thoáng mát, gần công viên và các dịch vụ tiện ích cao cấp.',
            'vi_tri' => 'công viên 300m; trường tiểu học 500m; siêu thị BigC 1km',
            'tien_ich' => 'Thang máy; Camera an ninh; Bảo vệ 24/7; Khu giặt giũ',
            'luot_xem' => 320,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 3,
            'ten' => 'Số 56 đường Hoa Hồng',
            'slug' => 'so-56-duong-hoa-hong',
            'image' => 'building/img',
            'mo_ta' => 'Vị trí lý tưởng, gần các trung tâm thương mại và công viên.',
            'vi_tri' => 'Vincom Plaza 800m; Bệnh viện 1.2km; Công viên hoa hồng 500m',
            'tien_ich' => 'Thang bộ; Thang máy; Phòng gym; Khu vực BBQ',
            'luot_xem' => 400,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 5,
            'ten' => 'Số 199 Pasteur',
            'slug' => 'so-199-pasteur',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà tọa lạc tại khu vực trung tâm thành phố, dễ dàng kết nối các tuyến đường lớn.',
            'vi_tri' => 'Nhà thờ Đức Bà 1km; Dinh Thống Nhất 1.5km; Vincom Center 2km',
            'tien_ich' => 'Thang máy; Hồ bơi; Gym; Bảo vệ 24/7',
            'luot_xem' => 700,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 1,
            'ten' => 'Số 45 Tân Sơn Nhì',
            'slug' => 'so-45-tan-son-nhi',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà cao cấp với thiết kế hiện đại, an ninh 24/7.',
            'vi_tri' => 'chợ Tân Sơn Nhì 300m; trường học 500m; siêu thị 1km',
            'tien_ich' => 'Camera an ninh; Thang bộ; Thang máy',
            'luot_xem' => 520,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 6,
            'ten' => 'Số 24/6 Lý Thường Kiệt',
            'slug' => 'so-24-6-ly-thuong-kiet',
            'image' => 'building/img',
            'mo_ta' => 'Gần khu vực thương mại và dễ dàng di chuyển đến các quận trung tâm.',
            'vi_tri' => 'Bệnh viện 600m; Chợ lớn 800m; Công viên 1.2km',
            'tien_ich' => 'Camera; Thang bộ; Khu giặt đồ; Gym',
            'luot_xem' => 620,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 7,
            'ten' => 'Số 15 Hòa Bình',
            'slug' => 'so-15-hoa-binh',
            'image' => 'building/img',
            'mo_ta' => 'Khu vực yên tĩnh, nhiều cây xanh.',
            'vi_tri' => 'Siêu thị 300m; Công viên Hòa Bình 1km; Trường học 1.5km',
            'tien_ich' => 'Bảo vệ; Camera; Thang bộ; Khu nấu ăn chung',
            'luot_xem' => 310,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 88 Phạm Văn Đồng',
            'slug' => 'so-88-pham-van-dong',
            'image' => 'building/img',
            'mo_ta' => 'Khu vực tiện nghi, giao thông thuận tiện.',
            'vi_tri' => 'Nhà ga 1km; Đại học Quốc gia 2km; Công viên 800m',
            'tien_ich' => 'Camera; Gym; Hồ bơi; Thang máy',
            'luot_xem' => 890,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 3,
            'ten' => 'Số 123 Nguyễn Thị Minh Khai',
            'slug' => 'so-123-nguyen-thi-minh-khai',
            'image' => 'building/img',
            'mo_ta' => 'Nằm tại trung tâm quận 3, gần các địa điểm quan trọng.',
            'vi_tri' => 'Công viên Tao Đàn 1km; Đại học Sư phạm 1.5km; Vincom Plaza 2km',
            'tien_ich' => 'Gym; Thang máy; Camera an ninh',
            'luot_xem' => 760,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 2,
            'ten' => 'Số 100A Dương Bá Trạc',
            'slug' => 'so-100a-duong-ba-trac',
            'image' => 'building/img',
            'mo_ta' => 'Khu vực thuận tiện di chuyển qua Quận 1, Quận 7 và Bình Chánh.',
            'vi_tri' => 'Chợ Dương Bá Trạc 400m; Trường THCS 600m; Khu Phú Mỹ Hưng 5km',
            'tien_ich' => 'Camera an ninh; Thang máy; Bãi xe rộng; Khu BBQ',
            'luot_xem' => 640,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 5,
            'ten' => 'Số 77 Lý Chính Thắng',
            'slug' => 'so-77-ly-chinh-thang',
            'image' => 'building/img',
            'mo_ta' => 'Nằm ở vị trí đắc địa giữa Quận 3 và Quận Phú Nhuận.',
            'vi_tri' => 'Công viên Lê Văn Tám 800m; Bệnh viện Quận 3 1km; Khu văn phòng 1.5km',
            'tien_ich' => 'Thang máy; Hồ bơi; Phòng gym; Camera an ninh',
            'luot_xem' => 950,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 6,
            'ten' => 'Số 66/2 đường Tân Sơn',
            'slug' => 'so-66-2-duong-tan-son',
            'image' => 'building/img',
            'mo_ta' => 'Khu vực dân cư đông đúc, tiện ích xung quanh phong phú.',
            'vi_tri' => 'Chợ Tân Sơn 500m; Nhà thờ Tân Sơn 800m; Bệnh viện 1.2km',
            'tien_ich' => 'Thang máy; Camera an ninh; Bảo vệ 24/7; Bãi giữ xe rộng',
            'luot_xem' => 500,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 7,
            'ten' => 'Số 145 Nguyễn Hữu Thọ',
            'slug' => 'so-145-nguyen-huu-tho',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà nằm trong khu đô thị hiện đại, an ninh và tiện nghi.',
            'vi_tri' => 'Đại học Tôn Đức Thắng 500m; Siêu thị Lotte Mart 1km; Khu Phú Mỹ Hưng 1.5km',
            'tien_ich' => 'Hồ bơi; Gym; Thang máy; Bảo vệ 24/7',
            'luot_xem' => 800,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 3,
            'ten' => 'Số 36/12 đường Hoàng Văn Thụ',
            'slug' => 'so-36-12-duong-hoang-van-thu',
            'image' => 'building/img',
            'mo_ta' => 'Vị trí trung tâm, dễ dàng tiếp cận các dịch vụ tiện ích.',
            'vi_tri' => 'Nhà thi đấu Tân Bình 600m; Công viên Hoàng Văn Thụ 800m; Sân bay Tân Sơn Nhất 2km',
            'tien_ich' => 'Thang máy; Camera; Bãi xe rộng; Khu vực sinh hoạt chung',
            'luot_xem' => 1020,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 6,
            'ten' => 'Số 28 Võ Văn Kiệt',
            'slug' => 'so-28-vo-van-kiet',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà hiện đại, vị trí đắc địa ngay mặt tiền đường lớn.',
            'vi_tri' => 'Cầu Ông Lãnh 500m; Chợ Bến Thành 1.5km; Khu phố đi bộ Nguyễn Huệ 2km',
            'tien_ich' => 'Hồ bơi; Thang máy; Camera an ninh; Gym',
            'luot_xem' => 870,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 4,
            'ten' => 'Số 9 Hùng Vương',
            'slug' => 'so-9-hung-vuong',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà phù hợp cho các hộ gia đình và nhân viên văn phòng.',
            'vi_tri' => 'Bệnh viện Chợ Rẫy 1km; Đại học Y Dược 1.5km; Chợ Lớn 2km',
            'tien_ich' => 'Thang máy; Camera; Khu vực BBQ; Bảo vệ 24/7',
            'luot_xem' => 720,
        ]);

        ToaNha::create([
            'khu_vuc_id' => 5,
            'ten' => 'Số 40A Nguyễn Trãi',
            'slug' => 'so-40a-nguyen-trai',
            'image' => 'building/img',
            'mo_ta' => 'Tòa nhà nằm gần các trung tâm thương mại và dịch vụ sầm uất.',
            'vi_tri' => 'Chợ Bến Thành 1km; Công viên Tao Đàn 1.5km; Nhà hát Thành phố 2km',
            'tien_ich' => 'Thang máy; Hồ bơi; Phòng gym; Camera an ninh',
            'luot_xem' => 1000,
        ]);
    }
}
