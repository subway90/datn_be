<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TinTuc;

class TinTucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 5 record mẫu cho bảng tin_tuc
        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 1, // ID danh mục 1
            'tieu_de' => 'Người thuê trọ điêu đứng vì chủ bán nhà trong cơn sốt giá',
            'slug' => 'nguoi-thue-tro-dieu-dung-vi-chu-ban-hang-trong-con-sot-gia',
            'image' => 'image1.jpg',
            'noi_dung' => 'Thuê ngôi nhà ba phòng ngủ được hai tháng, vừa rủ được đủ người ở cùng Minh Tùng nhận thông báo chủ nhà lấy lại để bán vì đang được giá.
            Nhận tin tôi xây xẩm mặt mày. Vừa bực vừa áy náy với những người đang thuê cùng mình, Minh Tùng, 25 tuổi, nói.
            
            Năm ngoái, anh thuê một căn nhà ở chung với mấy người bạn cùng quê. Ba tháng trước, chủ nhà cũng lấy lại với lý do bán nhân lúc đang giá cao. Nhóm đồng hương Quảng Ninh tỏa đi tìm chỗ trọ. Minh Tùng thuê được căn hộ bỏ không trong ngõ nhỏ ở quận Cầu Giấy, giá 7 triệu đồng, hợp đồng một năm. Anh đăng lên mạng, tìm thêm 5 người khác về ở cùng.

            Nhà bỏ không lâu ngày nên mấy người chia nhau dọn dẹp trước khi đến ở. Họ sắm thêm điều hòa, giường tủ, bình nóng lạnh, xác định ở lâu dài. Nhưng ở được hai tháng, chủ nhà đăng tin rao bán. Khách nườm nượp kéo đến xem. Chục ngày sau, chủ nhà thông báo đã bán với giá 23 tỷ đồng, lãi 11 tỷ sau 10 năm. Khách thuê trọ có một tháng để chuyển đi.

            Khách tìm phòng trọ trên phố Trần Quốc Vượng, Cầu Giấy, trưa 9/10. Ảnh: Quỳnh Nga
            Khách tìm phòng trọ trên phố Trần Quốc Vượng, Cầu Giấy, trưa 9/10. Ảnh: Quỳnh Nga

            Đầu năm 2023, Thùy Linh, 25 tuổi, thuê căn chung cư hai phòng ngủ ở quận Ba Đình, đóng tiền cả năm 96 triệu đồng. Tháng 8/2024, cô được yêu cầu đầu tháng 10 phải chuyển đi bởi căn hộ đã bán. Ngoài trả lại ba tháng tiền nhà, chủ bồi thường thêm 10 triệu tiền hợp đồng. "34 triệu đồng họ trả lại cho tôi có là gì so với việc bán được căn chung cư với giá gần 4 tỷ đồng", Linh nói.

            Không chỉ những người thuê trọ trong nội thành như Linh hay Tùng mới lâm cảnh "giữa đường đứt gánh", Ngọc Mai và em gái trọ ở xã An Khánh, huyện Hoài Đức cũng gặp cảnh tương tự.Chủ bảo không cần tiền, đất ngoại thành cũng khó bán nên cam kết cho thuê lâu dài, cô nói.

            Nhưng từ đầu năm 2024 khi giá nhà đất tăng, chủ liên tục đón khách đến xem nhà. Tháng 6 năm nay, họ bán giá 2,5 tỷ đồng.

            Bà Nguyễn Thị Thủy, người môi giới mảng nhà thuê phân khúc tầm trung ở Hà Nội, cho biết hiện tượng chủ nhà sẵn sàng bồi thường tiền cọc để lấy lại nhà bán xảy ra nhiều đột biến từ đầu năm 2024..',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 2, // ID danh mục 2
            'tieu_de' => 'Tin Công Nghệ 1',
            'slug' => 'tin-cong-nghe-1',
            'image' => 'image2.jpg',
            'noi_dung' => 'Nội dung cho tin công nghệ 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 3, // ID danh mục 3
            'tieu_de' => 'Tin Giải Trí 1',
            'slug' => 'tin-giai-tri-1',
            'image' => 'image3.jpg',
            'noi_dung' => 'Nội dung cho tin giải trí 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 4, // ID danh mục 4
            'tieu_de' => 'Tin Xã Hội 1',
            'slug' => 'tin-xa-hoi-1',
            'image' => 'image4.jpg',
            'noi_dung' => 'Nội dung cho tin xã hội 1.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 5, // ID danh mục 5
            'tieu_de' => 'Tin Giáo Dục 1',
            'slug' => 'tin-giao-duc-1',
            'image' => 'image5.jpg',
            'noi_dung' => 'Nội dung cho tin giáo dục 1.',
        ]);
    }
}
