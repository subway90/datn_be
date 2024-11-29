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
            'mo_ta' => 'Cơn sốt bất động sản tăng lên vì giá khiến tiền thuê trọ cũng tăng theo, tuy nhiên chất lượng vẫn như cũ khiến nhiều người khó khăn việc tìm giá trọ đúng với số tiền bỏ ra.',
            'slug' => 'nguoi-thue-tro-dieu-dung-vi-chu-ban-hang-trong-con-sot-gia',
            'image' => 'blog/image1.jpg',
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
            'tieu_de' => 'Luxora Bắc Giang - Toà Tháp Đôi Biểu Tượng Nằm Trong The Terra Được Văn Phú Invest Chuyển Nhượng Cho Chủ Đầu Tư Mới New Goldsun',
            'mo_ta' => 'New Goldsun chính thức tiếp nhận quyền phát triển tòa tháp đôi thuộc dự án The Terra - Bắc Giang từ Văn Phú - Invest. Công trình biểu tượng này đánh dấu bước tiến mới, góp phần kiến tạo diện mạo hiện đại và kết nối cho trung tâm vùng Bắc Giang.',
            'slug' => 'luxora-bac-giang-toa-thap-doi-bieu-tuong-nam-tromg-the-terra-duoc-van-phu-invest-chuyen-nhuong-cho-chu-dau-tu-moi-new-goldsun',
            'image' => 'blog/image2.jpg, blog/image3.jpg',
            'noi_dung' => '
            Ngày 2/8/2024 tại Hà Nội, buổi lễ ký kết đã diễn ra thành công, mở ra chương mới cho hành trình kiến tạo của New Goldsun tại The Terra – Bắc Giang. Dự án The Terra giờ đây chính thức có tên gọi mới “Luxora”. Với diện tích 4,5 ha, dự án tọa lạc tại vị trí đắc địa, kết nối linh hoạt giữa trung tâm thành phố và các vùng phụ cận, tạo điều kiện thuận lợi cho cư dân tiếp cận các tiện ích hiện đại và dịch vụ cao cấp. Trong đó, tòa tháp đôi được thiết kế với phong cách kiến trúc độc đáo, mang lại không gian sống đẳng cấp, đồng thời đóng vai trò là biểu tượng kiến trúc mới, nâng tầm giá trị khu đô thị.

            Thừa hưởng nền tảng thành công từ phần thấp tầng của Văn Phú, New Goldsun tiếp tục phát triển dự án với tầm nhìn xa, hướng tới một không gian sống xanh, bền vững và tích hợp đầy đủ các tiện ích cho cộng đồng. Toà tháp đôi Luxora không chỉ là nơi ở, mà còn là không gian giao lưu kết nối, với hàng loạt tiện ích vượt trội như công viên cây xanh rộng lớn, khu vui chơi giải trí, và các khu sinh hoạt cộng đồng hiện đại, đáp ứng tối đa nhu cầu sống và thư giãn của cư dân.

            Sự chuyển nhượng dự án giữa New Goldsun và Văn Phú – Invest không đơn thuần là một thương vụ kinh tế, mà còn là bước đệm cho sự mở rộng và phát triển dài hạn của New Goldsun trong lĩnh vực bất động sản. Với vị trí chiến lược và tiềm năng phát triển mạnh mẽ, Luxora vừa là không gian sống lý tưởng mà còn là cơ hội đầu tư hấp dẫn, tạo nên sức hút lớn trên thị trường bất động sản khu vực phía Bắc.

            New Goldsun cam kết mang đến một không gian sống hiện đại, an toàn và thân thiện, góp phần thay đổi diện mạo đô thị Bắc Giang, đồng thời khẳng định vị thế vững chắc của mình trên bản đồ bất động sản Việt Nam. Thương vụ chuyển nhượng này là minh chứng cho tầm nhìn dài hạn và khát vọng phát triển bền vững của New Goldsun, hứa hẹn sẽ mang đến cho cư dân Bắc Giang một trải nghiệm sống hoàn hảo, góp phần thúc đẩy sự phát triển kinh tế – xã hội của khu vực.',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 3, // ID danh mục 3
            'tieu_de' => 'Đông Tây Land Ký Kết Hợp Tác Mở Ra Những Cơ Hội Mới Cùng CaraWorld Cam Ranh',
            'mo_ta' => 'Ngày 20/11/2024, tại Trung tâm hội nghị sự kiện Gem Center (TP.HCM), Tập đoàn KN Holdings và Công Ty Cổ Phần Đông Tây Land đã chính thức trở thành đại lý phân phối chiến lược quy mô lớn dự án siêu đô thị biển CaraWorld Cam Ranh.',
            'slug' => 'dong-tay-land-ky-ket-hop-tac-mo-ra-nhung-co-hoi-moi-cung-caraworld-cam-ranh',
            'image' => 'blog/image4.jpg',
            'noi_dung' => '
            CaraWorld là dự án được Chủ đầu tư KN Holdings quy hoạch trở thành đô thị trái tim, tâm điểm vui chơi – giải trí – nghỉ dưỡng sôi động bậc nhất Khánh Hòa nói riêng và khu vực Nam Trung Bộ nói chung. Với quy mô lên đến 800 ha – là dự án có diện tích lớn bậc nhất trên bản đồ bất động sản biển, CaraWorld được xây dựng với hệ sinh thái đầy đủ các phân khu vui chơi giải trí hiện đại, khu nghỉ dưỡng 5 sao, khu mua sắm sầm uất, sân golf và các khu công viên sinh thái, tâm linh độc đáo cùng 38 đại tiện ích được đầu tư bài bản.

            Dự án này còn nắm giữ những lợi thế đặc biệt khi sở hữu 1/3 đường bờ biển riêng tại Bãi Dài thiên đường, và là đô thị biển hiếm hoi có quỹ đất sở hữu lâu dài. Tiếp đến, đây là dự án đô thị biển duy nhất liền kề sân bay quốc tế Cam Ranh sẽ giúp tạo lợi thế đón đầu lượng du khách đổ về từ khắp nơi.

            CaraWorld còn được ví von với các câu từ là “Thành phố 2 giờ – Trong mát ngoài vui” nhờ dễ dàng kết nối với nhiều tỉnh thành tại Việt Nam chỉ trong 2 giờ nhờ với các tuyến giao thông thuận tiện: tuyến cao tốc Buôn Mê Thuột – Cam Ranh dự kiến hoàn thành vào năm 2026, tuyến cao tốc Đà Lạt – Cam Ranh dự kiến hoàn thành vào năm 2028, tuyến đường sắt cao tốc TPHCM – Cam Ranh được dự kiến hoàn thành vào năm 2035 hay có thể sử dụng đường hàng không với tuyến Hà Nội – Cam Ranh. Đặc biệt, dự án được quy hoạch với tỷ lệ vàng 70/30 với 70% tiện ích sẽ được quy hoạch trong mát đem lại cảm giác dễ chịu: Bảo tàng yến, Nhà ánh sáng, Công viên kẹo ngọt ,.. và 30% tiện ích ngoài trời mang đến sự sôi động: Tổ hợp tiện ích bãi biển, Công viên nước, Trường đua GT,..

            Trong vai trò là nhà phát triển dự án, KN Holdings đã và đang tập trung nguồn lực hợp tác với các đối tác uy tín hàng đầu trong và ngoài nước để mang đến những trải nghiệm sống, nghỉ dưỡng, giải trí hoàn hảo nhất cho khách hàng. Ngày 20/11/2024 vừa qua, chủ đầu tư này đã tổ chức sự kiện “Lễ ký kết đối tác chiến lược phát triển dự án CaraWorld” để công bố danh sách các đại lý phân phối bất động sản uy tín trên thị trường trở thành đại lý phân phối chính thức của dự án.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 4, // ID danh mục 4
            'tieu_de' => 'Hà Nội Đẩy Mạnh Việc Triển Khai Đầu Tư Xây Dựng Một Số Cầu Lớn Qua Sông Hồng',
            'mo_ta' => 'Giai đoạn từ năm 2025-2030, Hà Nội thống nhất về chủ trương đầu tư một số cầu lớn qua sông Hồng, gồm Cầu Tứ Liên, cầu Trần Hưng Đạo và cầu Ngọc Hồi. Các cây cầu sẽ đóng vai trò quan trọng trong mạch giao thương thông suốt của toàn thành phố, tạo nên những biến chuyển mới về kinh tế- xã hội và diện mạo đô thị.',
            'slug' => 'ha-noi-day-manh-viec-trien-khai-dau-tu-xay-dung-mot-so-cau-lon-qua-song-hong-cd-hn',
            'image' => 'blog/image5.jpg',
            'noi_dung' => '
            Mới đây nhất, tại trụ sở UBND Thành phố, Chủ tịch UBND Thành phố Trần Sỹ Thanh đã chủ trì buổi làm việc về tình hình triển khai đầu tư xây dựng một số cầu lớn qua sông Hồng trên địa bàn Thành phố. Kết thúc cuộc họp, Văn phòng UBND TP. Hà Nội chính thức có thông báo kết luận của lãnh đạo thành phố về tình hình triển khai đầu tư xây dựng một số cầu lớn qua sông Hồng.

            Theo đó, sau khi nghe báo cáo, đề xuất của Sở Kế hoạch và Đầu tư và ý kiến của các đại biểu dự họp, Chủ tịch UBND Thành phố thống nhất kết luận, chỉ đạo như sau: Thống nhất về chủ trương đầu tư một số cầu lớn qua sông Hồng trong giai đoạn từ năm 2025-2030.

            Cụ thể, thống nhất về chủ trương thực hiện Dự án đầu tư xây dựng cầu Tứ Liên và đường từ cầu Tứ Liên đến cao tốc Hà Nội – Thái Nguyên bằng vốn đầu tư công (đầu tư xây dựng cầu Tứ Liên và đoạn đường từ cầu Tứ Liên đến đường Trường Sa nghiên cứu theo theo hướng hợp đồng EPC). Phó Chủ tịch UBND Thành phố Dương Đức Tuấn được phân công làm việc với doanh nghiệp để trao đổi, thống nhất phương án đầu tư xây dựng cầu Tứ Liên đảm bảo đảm bảo khả thi, hiệu qủa, sớm triển khai đầu tư xây dựng.

            Lãnh đạo thành phố giao Sở Kế hoạch và Đầu tư khẩn trương xem xét Tờ trình số 5744/TTr-SGTVT ngày 06/11/2024 của Sở Giao thông vận tải về Báo cáo nghiên cứu tiền khả thi Dự án đầu tư, tham mưu, đề xuất báo cáo UBND Thành phố trình cơ quan có thẩm quyền tổ chức thẩm định, phê duyệt chủ trương đầu tư trong tháng 01/2025; tham mưu, đề xuất phương án bố trí vốn đầu tư công thực hiện dự án đầu tư.

            Bên cạnh đó, dự án đầu tư xây dựng cầu Trần Hưng Đạo và đường hai đầu cầu được thống nhất về chủ trương thực hiện đầu tư bằng nguồn vốn đầu tư công. Sở Giao thông vận tải được giao nhiệm vụ khẩn trương tổ chức lập Báo cáo nghiên cứu tiền khả thi Dự án đầu tư, trình cơ quan có thẩm quyền tổ chức thẩm định, phê duyệt theo đúng quy trình, quy định; báo cáo UBND Thành phố trong tháng 2/2025. Ngoài ra,Sở Kế hoạch và Đầu tư sớm tham mưu, đề xuất phương án bố trí vốn đầu tư công thực hiện Dự án đầu tư, đảm bảo khả thi, hiệu qủa, sớm triển khai đầu tư xây dựng.

            Với cầu Ngọc Hồi và đường dẫn hai đầu cầu, dự án được thống nhất về chủ trương thực hiệ bằng nguồn vốn đầu tư công (nguồn vốn của thành phố Hà Nội, của tỉnh Hưng Yên và vốn hỗ trợ của Trung ương theo quy định). Lãnh đạo thành phố giao các Sở: Giao thông vận tải, Nông nghiệp và Phát triển nông thôn, Văn hóa và Thể thao, Kế hoạch và Đầu tư, Quy hoạch – Kiến trúc; UBND các huyện: Thanh Trì, Gia Lâm khẩn trương triển khai thực hiện chỉ đạo của lãnh đạo UBND thành phố Hà Nội, lãnh đạo UBND tỉnh Hưng Yên tại Thông báo số 451/TB-VP ngày 27/9/2024.

            Sở Quy hoạch – Kiến trúc Hà Nội tham mưu, để xuất UBND Thành phố việc tổ chức thi tuyển phương án kiến trúc cầu chính qua sông Hồng, báo cáo UBND Thành phố trong tháng 12/2024. Sở Kế hoạch và Đầu tư khẩn trương xem xét Tờ trình số 1179/TTrSGTVT ngày 07/11/2024 của Sở Giao thông vận tải về Báo cáo nghiên cứu tiền khả thi dự án đầu tư, tham mưu, đề xuất báo cáo UBND Thành phố trình cơ quan có thẩm quyền tổ chức thẩm định, phê duyệt chủ trương đầu tư trong tháng 01/2025; tham mưu, đề xuất phương án bố trí vốn đầu tư công thực hiện dự án đầu tư.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 5, // ID danh mục 5
            'tieu_de' => 'Hội Môi Giới Bất động Sản Việt Nam Công Bố “Bộ Quy Tắc Đạo Đức Và Ứng Xử Nghề Nghiệp Môi Giới Bất Động Sản Việt Nam - VPEC 2024”',
            'mo_ta' => 'Mới đây, Hội nghị “Công bố Bộ Quy tắc Đạo đức và Ứng xử Nghề nghiệp Môi giới Bất động sản Việt Nam – VPEC 2024” đã được tổ chức thành công với sự tham dự của đại diện Bộ Xây dựng, các chuyên gia uy tín trong ngành, cùng hơn 200 đại biểu từ các doanh nghiệp, các sàn giao dịch bất động sản và cá nhân hoạt động trong lĩnh vực bất động sản trên toàn quốc. Hội nghị do Viện Nghiên cứu Đánh giá thị trường bất động sản Việt Nam (VARS IRE) phối hợp cùng VARs Connect thực hiện tổ chức dưới sự chỉ đạo của Hội Môi giới Bất động sản Việt Nam.',
            'slug' => 'hoi-moi-gioi-bat-dong-san-viet-nam-cong-bo-bo-quy-tac-dao-duc-va-ung-xu-nghe-nghiep-moi-gioi-bat-dong-san-viet-nam-vpec-2024',
            'image' => 'blog/image6.jpg, blog/image7.jpg',
            'noi_dung' => '
            Tại Hội nghị, Ông Nguyễn Mạnh Quỳnh, Phó Tổng Thư ký kiêm Chánh Văn phòng đã thay mặt Ban Chấp hành VARS chính thức công bố Bộ Quy tắc Đạo đức và Ứng xử dành cho Môi giới Bất động sản, bản sửa đổi và bổ sung 2024, cùng với lần đầu tiên công bố Bộ Quy tắc Đạo đức và Ứng xử dành riêng cho các Sàn Giao dịch Bất động sản, trong đó:

            Bộ Quy tắc Đạo đức và Ứng xử dành cho các Sàn giao dịch Bất động sản: Gồm 5 chương và 22 điều, tập trung vào các quy định liên quan đến trách nhiệm đối với khách hàng, ứng xử nội bộ, hợp tác giữa các sàn và trách nhiệm với thị trường, xã hội,…

            Bộ Quy tắc Đạo đức và Ứng xử nghề nghiệp dành cho Nhà Môi giới Bất động sản: Gồm 6 chương và 21 điều, quy định chi tiết các nguyên tắc đạo đức và chuẩn mực ứng xử trong các mối quan hệ với khách hàng, đồng nghiệp, thị trường và cộng đồng,…

            Bộ Quy tắc Đạo đức, Văn hóa và Ứng xử Nghề nghiệp dành cho Nhà Môi giới Bất động sản và Sàn Giao dịch Bất động sản được xây dựng nhằm thiết lập các chuẩn mực hành nghề, với nội dung bao quát nhiều khía cạnh. Trong đó, quy định các quy tắc chung tập trung vào việc ứng xử với khách hàng, đảm bảo tính trung thực, tận tâm và ngăn ngừa xung đột lợi ích; ứng xử với đồng nghiệp, đề cao tinh thần hỗ trợ, hợp tác và cạnh tranh lành mạnh; ứng xử với thị trường, góp phần thúc đẩy sự minh bạch, công bằng; và ứng xử với xã hội, gắn liền trách nhiệm nghề nghiệp với lợi ích cộng đồng. Các quy tắc này được phân chia chi tiết thành nhiều chương, cụ thể hóa từng tình huống để đảm bảo tính khả thi và phù hợp với thực tiễn.

            Các quy tắc được VARS xây dựng nhằm đảm bảo hoạt động Môi giới Bất động sản diễn ra minh bạch, công bằng, góp phần tạo dựng niềm tin của khách hàng và thúc đẩy sự phát triển bền vững của thị trường bất động sản.

            Phát biểu tại hội nghị, đại diện Bộ Xây dựng, ông Nguyễn Hồng Phú cho biết: “Việc công bố Bộ Quy tắc Đạo đức và Ứng xử nghề nghiệp Môi giới Bất động sản Việt Nam là một dấu mốc đặc biệt quan trọng, khẳng định sự phát triển bền vững và chuyên nghiệp của ngành bất động sản. Bộ Xây dựng đánh giá cao những nỗ lực của VARS trong việc thúc đẩy các giá trị minh bạch, đạo đức, và chuẩn mực nghề nghiệp. Bộ Quy tắc không chỉ là kim chỉ nam cho các cá nhân và tổ chức trong ngành mà còn đặt nền móng vững chắc để xây dựng hình ảnh một cộng đồng Môi giới có trách nhiệm, uy tín và tuân thủ pháp luật.

            Lần đầu tiên, một Bộ Quy tắc riêng dành cho các Sàn giao dịch được giới thiệu, thể hiện sự toàn diện trong việc thiết lập các tiêu chuẩn cao nhất. Bộ Xây dựng cam kết sẽ tiếp tục đồng hành cùng VARS trong việc phổ biến và triển khai các quy tắc này, nhằm thúc đẩy thị trường bất động sản phát triển minh bạch, lành mạnh, đóng góp tích cực vào sự thịnh vượng của đất nước..

            Chia sẻ về vai trò và cách thực thi bộ quy tắc đạo đức nghề Môi giới Bất động sản, dưới góc độ doanh nghiệp, Ông Dương Quốc Thủy – CEO Đất Xanh Miền Tây nhấn mạnh rằng, đối với các doanh nghiệp làm dịch vụ lâu năm, hai yếu tố cốt lõi cần được đặt lên hàng đầu là: tuân thủ pháp luật và xây dựng văn hóa doanh nghiệp dựa trên bộ quy tắc. Ông chia sẻ, văn hóa doanh nghiệp của Đất Xanh được xây dựng trên 4 giá trị cốt lõi: khát vọng, chuyên nghiệp, nhân văn, và chính trực; đồng thời ông hy vọng bộ quy tắc sẽ được các công ty Môi giới xem như kim chỉ nam và lợi thế cạnh tranh trong hoạt động.

            Ông Thủy cho rằng, kinh doanh Bất động sản là ngành nghề có điều kiện, đòi hỏi người hành nghề phải có chứng chỉ và tuân thủ các quy định tổ chức. Do đó, cần đưa bộ quy tắc này vào nội dung đào tạo chính thức. Nếu Môi giới Bất động sản làm việc chân chính và được công nhận, thì bộ quy tắc này không chỉ giúp xây dựng thị trường bền vững, mà còn góp phần nâng cao vị thế nghề nghiệp. “Tôi thực sự bức xúc khi nghe trong các hội thảo, Môi giới Bất động sản bị gọi là ‘cò đất’. Đã đến lúc chúng ta phải cùng nhau xây dựng một cộng đồng Môi giới chuyên nghiệp.

            Phát biểu tổng kết, TS. Nguyễn Văn Đính – Chủ tịch VARS khẳng định: “Bộ Quy tắc Đạo đức và Ứng xử Nghề nghiệp không chỉ là kim chỉ nam cho các hoạt động Môi giới mà còn củng cố niềm tin xã hội, thúc đẩy sự phát triển lành mạnh của thị trường bất động sản. VARS cam kết sẽ đồng hành cùng cộng đồng Môi giới và các doanh nghiệp để triển khai Bộ Quy tắc một cách hiệu quả, thông qua các chương trình đào tạo, cơ chế giám sát chặt chẽ, và tôn vinh những cá nhân, tổ chức tiêu biểu, góp phần nâng cao vị thế của nghề Môi giới Bất động sản tại Việt Nam. Các tổ chức, Sàn giao dịch và cá nhân trong ngành hãy xem Bộ Quy tắc như một nội quy nghề nghiệp, lấy đó làm động lực để nâng tầm văn hóa doanh nghiệp và lan tỏa những giá trị đạo đức trong ngành bất động sản.

            Bên cạnh đó, ông cũng kêu gọi toàn ngành cam kết thực hiện nghiêm túc, đồng bộ các quy tắc, đồng thời nhấn mạnh sự cần thiết của sự chung tay từ Chính phủ, các chuyên gia, và toàn thể cộng đồng để đưa Nghề Môi giới Bất động sản Việt Nam vươn tầm quốc tế. Chúng tôi cam kết đồng hành cùng các cá nhân, tổ chức trong việc áp dụng hiệu quả Bộ Quy tắc này vào thực tế, góp phần nâng cao vị thế của nghề Môi giới Bất động sản tại Việt Nam.”
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 6,
            'tieu_de' => 'Chuyên Gia Đến Hải Phòng Thuê Căn Hộ Ở Đâu?',
            'mo_ta' => 'Một không gian sống luôn cân bằng giữa an tĩnh và sôi động, tự do và riêng tư, biệt lập mà tiện ích và dễ dàng di chuyển, đó là tất cả những gì các chuyên gia cần cho một không gian sống. Hải Phòng, điểm đến thu hút của đông đảo chuyên gia trong và ngoài nước liệu đã sẵn sàng đáp ứng nhu cầu về chốn an cư lý tưởng cho chuyên gia?',
            'slug' => 'chuyen-gia-den-hai-phong-thue-can-ho-o-dau',
            'image' => 'blog/image8.jpg, blog/image9.jpg',
            'noi_dung' => '
            Nằm trong top 20 hải cảng trên thế giới đón tàu siêu trọng, Hải Phòng luôn là đầu tàu kinh tế của các tỉnh phía Bắc. Sức hút của Hải Phòng đến từ tiềm lực phát triển kinh tế mạnh mẽ. Hiện có khoảng 9000 người nước ngoài đang sinh sống tại Hải Phòng và con số này sẽ còn tiếp tục tăng lên.

            Họ mang theo văn hóa, lối sống và cả những tiêu chuẩn riêng về không gian sống. Một không gian sống đẹp đẽ, luôn cân bằng giữa an tĩnh và sôi động, tự do và riêng tư, biệt lập mà tiện ích và dễ dàng di chuyển, đó là tất cả những gì các chuyên gia cần cho một không gian sống.

            “12 năm trước, chúng tôi đã có mặt ở đây, chọn ra mảnh đất phù hợp để xây dựng những không gian sống chất lượng cho những cư dân toàn cầu.” – ông Jeong Cheol, thành viên HĐQT của N.H.O, một công ty BĐS Hàn Quốc cho biết. Với tầm nhìn xa như thế, Gem Park – một dự án trọng điểm của N.H.O nổi lên như một điểm sáng, đáp ứng trọn vẹn những mong đợi của giới chuyên gia tại thành phố cảng.

            Một ngôi nhà do chính các chuyên gia nước ngoài thiết kế, sẽ đáp ứng tốt nhất nhu cầu của người dùng. Với thiết kế thông minh, tinh tế trong từng cú chạm, các tiện ích bên trong căn hộ phải được đặt ở những vị trí thuận tiện nhất, để người dùng có thể dễ dàng sử dụng và tối đa hiệu quả trong tối thiểu thời gian. Gem Park còn tận dụng tối đa ánh sáng và gió tự nhiên, tạo nên không gian sống trong lành, thoáng đãng. Ngoài nắng sớm và làn gió dịu nhẹ len lỏi khắp căn hộ, Gem Park còn là nơi màu xanh thiên nhiên giao hòa từ bên trong ngôi nhà ra đến bên ngoài.

            Hệ thống tiện ích với diện ích lên đến 15.000 m2 tại nội khu, đa dạng và hoàn toàn miễn phí là điểm cộng lớn của Gem Park. Phòng gym hiện đại, phòng yoga yên tĩnh, hồ bơi trong xanh… tất cả đều sẵn sàng phục vụ nhu cầu rèn luyện sức khỏe, thư giãn của cư dân. Công viên 10.000 m2, được các nhà thiết kế cảnh quan xứ sở kim chi lấy cảm hứng từ phong cảnh lãng mạn quê hương mình, để tái tạo nên một phiên bản thiên nhiên Hàn Quốc thu nhỏ tại Gem Park. Con đường hồng rực sắc hoa anh đào vào mùa xuân bên con hồ Seokchon thơ mộng đã được tái hiện bằng con đường rực sắc tím, trắng hoa ban – loài hoa xinh đẹp, thanh khiết của núi rừng Tây Bắc Việt Nam.

            Từ căn hộ, chỉ cần một cú chạm, là cư dân có thể tiếp cận để tận hưởng hệ tiện ích trong nhà rộng 5,000m2. Bước ra giữa trung tâm nội khu là hồ bơi điện phân muối rộng 500m2, bao gồm hồ bơi người lớn và hồ bơi thiếu nhi với chuỗi tiện ích bên hồ chuẩn resort như các loại ghế sưởi nắng chuyên dụng, ghế bán nổi, ghế bán chìm để cư dân có thể vừa hưởng sự thư thái giữa làn nước mát, vừa chia sẻ đam mê bơi lội cùng gia đình, bạn bè.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 7,
            'tieu_de' => 'Khám Phá Diện Mạo Của Trung Tâm Thương Mại Hanoi Centre: Điểm Đến “Trung Tâm” Mới Của Hà Nội',
            'mo_ta' => 'Tiếp nối thành công của các trung tâm thương mại Saigon Centre và Estella Place tại TP.HCM, Keppel đã chính thức gia nhập "cuộc đua" bất động sản thương mại tại Hà Nội với việc thuê toàn bộ khu trung tâm thương mại Hanoi Centre tại quận Ba Đình để quản lý, vận hành và khai thác.',
            'slug' => 'kham-pha-dien-mao-cua-trung-tam-thuong-mai-hanoi-centre-diem-den-trung-tam-moi-cua-ha-noi',
            'image' => 'blog/image10.jpg, blog/image11.jpg',
            'noi_dung' => '
            Hanoi Centre tọa lạc tại 175 Nguyễn Thái Học, quận Ba Đình, Hà Nội – một khu vực đắc địa giữa lòng nội đô. Vị trí chiến lược của dự án không chỉ gần Quảng trường Ba Đình mà còn gần các điểm du lịch nổi tiếng như Văn Miếu Quốc Tử Giám và Hồ Tây.

            Trung tâm thương mại Hanoi Centre là một phần của dự án Khu Phức Hợp Tiến Bộ Plaza, bao gồm trung tâm thương mại, khách sạn, văn phòng hạng A và căn hộ dịch vụ. Sự kết hợp này tạo ra một không gian sôi động, thu hút nhiều nhóm khách hàng như nhân viên văn phòng, du khách, khách doanh nhân và người mua sắm. Với diện tích sàn rộng lớn lên đến 72.000 m2 và 5 tầng mua sắm, Hanoi Centre hứa hẹn trở thành điểm đến hấp dẫn và toàn diện cho khách hàng.

            Hanoi Centre sẽ là trung tâm của nhiều cửa hàng bán lẻ, từ các thương hiệu quốc tế cao cấp đến các sản phẩm địa phương chất lượng. Trung tâm còn có các khu vực giải trí như rạp chiếu phim, khu vui chơi và các sự kiện văn hóa, mang đến cho du khách những trải nghiệm văn hóa Việt Nam đặc sắc.

            Trung tâm thương mại còn định hướng phát triển nhiều nhà hàng và quán café với thực đơn phong phú, từ món ăn Việt Nam truyền thống đến các món quốc tế, tạo điều kiện cho du khách khám phá ẩm thực trong không gian hiện đại và sang trọng. Với vị trí trung tâm, Hanoi Centre sẽ là điểm dừng chân lý tưởng cho du khách, đặc biệt là những người lưu trú tại các khách sạn hoặc tham quan các điểm du lịch nổi tiếng gần đó.

            Một trong những điểm nhấn độc đáo của Hanoi Centre là việc bảo tồn cây đa 100 tuổi, cùng thiết kế thác nước và cầu thang đẹp mắt dẫn xuống tầng hầm trung tâm thương mại. Ngoài ra, Hanoi Centre cũng nằm gần Khu di tích lịch sử Trại giam Nhà Tiền, hứa hẹn mang đến cho du khách một hoạt động trải nghiệm tham quan di tích lịch sử phong phú và sâu sắc.

            Trung tâm thương mại Hanoi Centre không chỉ phục vụ các mặt hàng cao cấp mà còn cung cấp các cửa hàng tiện lợi, siêu thị, rạp chiếu phim và nhiều dịch vụ khác đáp ứng mọi nhu cầu của cư dân địa phương.

            Với thiết kế hiện đại kết hợp cùng không gian xanh mát, Hanoi Centre không chỉ mang đến trải nghiệm mua sắm đẳng cấp mà còn tạo ra một môi trường lý tưởng cho các gia đình tìm kiếm sự thoải mái và giải trí lành mạnh. Bên cạnh đó, với các tiện ích giải trí đa dạng, từ khu vui chơi cho trẻ em đến các khu vực thư giãn dành cho người lớn, Hanoi Centre hứa hẹn sẽ là điểm đến tuyệt vời cho mọi thành viên trong gia đình, mang lại những khoảnh khắc gắn kết và vui vẻ trong mỗi lần ghé thăm.

            Bên cạnh đó, khu vực sảnh rộng rãi, được thiết kế thuận tiện cho việc di chuyển là một điểm nổi bật, khắc phục được hạn chế về không gian của nhiều trung tâm thương mại tại Hà Nội. Đây sẽ là không gian lý tưởng cho các sự kiện và lễ hội diễn ra quanh năm, thu hút đông đảo khách hàng tham gia và tạo nên không khí nhộn nhịp, sôi động cho trung tâm.

            Theo thông tin ban đầu, trung tâm thương mại Hanoi Centre sẽ có một Quảng trường Trung Tâm, không gian kết nối các khu vực và tích hợp các hoạt động trong nhà và ngoài trời. Quảng trường này sẽ được trang trí bằng không gian xanh mát, tạo ra một môi trường thư giãn và dễ chịu. Đây sẽ là địa điểm lý tưởng cho các hoạt động cộng đồng như hội chợ theo chủ đề, triển lãm, diễn đàn và các sự kiện khác, góp phần tạo nên bầu không khí cuốn hút.

            Với vị trí đắc địa, thiết kế hiện đại và dịch vụ chất lượng, Hanoi Centre sẽ không chỉ là biểu tượng mới về kiến trúc và phong cách sống hiện đại của Hà Nội mà còn là bước tiến quan trọng trong chiến lược dài hạn của Keppel tại Việt Nam. Dự án này khẳng định sự cam kết và khả năng vận hành của công ty trong việc nâng cao tiêu chuẩn của các dự án bất động sản tại thị trường đầy tiềm năng này.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 8,
            'tieu_de' => 'Phân Khúc Bất Động Sản Nào Đang Thăng Hoa Nhờ Nguồn Vốn FDI?',
            'mo_ta' => 'Nguồn vốn FDI đang đóng góp một phần không nhỏ vào sự khởi sắc của thị trường bất động sản. Nhiều phân khúc bất động sản đã được hưởng lợi lớn cùng sự tăng trưởng của nguồn vốn này.',
            'slug' => 'phan-khuc-bat-dong-san-nao-dang-thang-hoa-nho-nguon-von-fdi-cd-hn',
            'image' => 'blog/image12.jpg, blog/image13.jpg',
            'noi_dung' => '
            Báo cáo mới nhất của Tổng cục Thống kê đưa ra những thông tin đáng chú ý về nguồn vốn FDI. Theo đó, tính đến ngày 31/8, tổng vốn đầu tư trực tiếp nước ngoài (FDI) đăng ký vào Việt Nam đạt 20,52 tỉ USD. Con số này tăng hơn 8% so với cùng kỳ năm trước. Đặc biệt, lĩnh vực kinh doanh bất động sản chiếm gần 20% tổng vốn đăng ký cấp mới, đạt 2,4 tỉ USD, gấp 5,1 lần cùng kỳ. Nếu tính cả vốn đăng ký mới và vốn đăng ký điều chỉnh, vốn FDI đăng ký vào hoạt động kinh doanh bất động sản đạt 2,55 tỉ USD, gấp 3,7 lần cùng kỳ và chiếm gần 14,4% tổng vốn đăng ký cấp mới và tăng thêm.

            Vào cuối tháng 8, số liệu từ Ngân hàng Thế giới cho biết, GDP Việt Nam dự kiến ​​sẽ tăng trưởng 6,1% vào năm 2024, tăng so với mức 5% vào năm 2023. Lạm phát được dự báo ​​sẽ được kiểm soát ở mức 4,5% trong năm 2024.Cùng với tăng trưởng của nguồn vốn FDI, những chỉ số kinh tế này cho thấy nền kinh tế phát triển ổn định, tạo đà cho sự cất cánh của thị trường bất động sản.

            Ông Nguyễn Quốc Anh, Phó tổng giám đốc Batdongsan.com.vn cho biết, nguồn vốn FDI có vai trò lớn với thị trường bất động sản Việt Nam trong việc khơi thông nguồn cung và chuẩn hóa thị trường với các tiêu chí khắt khe của nguồn vốn ngoại về pháp lý, quy hoạch, cách thức phát triển sản phẩm. Một số phân khúc như bất động sản công nghiệp, văn phòng, nhà ở, nghỉ dưỡng – những loại hình mà khối ngoại quan tâm sẽ chịu tác động trực tiếp của nguồn vốn này.

            Cũng theo ông Quốc Anh, ba luật liên quan đến thị trường bất động sản là Luật Nhà ở 2023, Luật Kinh doanh Bất động sản 2023 và Luật Đất đai 2024 chính thức có hiệu lực tạo hành lang thông thoáng cho thị trường bất động sản, cộng hưởng với nền kinh tế phát triển ổn định, hạ tầng được đầu tư phát triển mạnh mẽ khiến thị trường bất động sản Việt Nam trở nên hấp dẫn trong mắt các nhà đầu tư nước ngoài. Giới đầu tư nước ngoài có niềm tin và họ đổ tiền mạnh mẽ hơn vào Việt Nam nhờ sự hỗ trợ của hàng hang pháp lý. Hành lang pháp lý tạo một môi trường pháp lý ổn định và minh bạch, đồng nghĩa thời gian phê duyệt dự án được rút ngắn, nhà đầu tư xác định rõ ràng chi phí đầu tư ban đầu (chi phí sử dụng đất), từ đó giúp các dự án đầu tư bất động sản trở nên hấp dẫn hơn”,Chính điều này đã khiến vốn FDI vào bất động sản tăng mạnh trong các quý vừa qua.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 9,
            'tieu_de' => 'Chủ Đầu Tư Kim Long Kiến Tạo Khu Đô Thị Chuẩn Nhật Đầu Tiên Tại Đông Triều',
            'mo_ta' => 'Fujisan Đông Triều là dự án tâm huyết của Chủ đầu tư (CĐT) Kim Long với khát vọng kiến tạo biểu tượng sống mới cho người dân tại thành phố thứ 5 của tỉnh Quảng Ninh. Lần đầu tiên, Đông Triều xuất hiện một khu đô thị bán khép kín với chuỗi tiện ích và kiến trúc xây dựng mang phong cách từ đất nước mặt trời mọc.',
            'slug' => 'chu-dau-tu-kim-long-kien-tao-khu-do-thi-chuan-nhat-dau-tien-tai-dong-trieu',
            'image' => 'blog/image14.jpg, blog/image15.jpg',
            'noi_dung' => '
            Được biết đến là một trong những nhà thầu xây dựng uy tín tại Đông Triều, Công ty cổ phần Kim Long chính là đơn vị đã thực hiện có hiệu quả nhiều dự án hạ tầng kỹ thuật, công trình giao thông từ vốn ngân sách địa phương. Một số dự án cải tạo chỉnh trang đô thị nổi bật bao gồm: Hạ tầng kỹ thuật đất khu dân cư khu Yên Lâm 3, phường Đức Chính; Đường nối ngã ba đường tránh Hưng Đạo đến khu đô thị Hồng Phong; Hạ tầng kỹ thuật đất dân cư tại khu Vĩnh Hòa, phường Mạo Khê (khu C)… Không chỉ ghi dấu ấn bởi chất lượng xây dựng, Kim Long còn được đánh giá là một trong những CĐT luôn đặt yếu tố pháp lý dự án lên hàng đầu.

            Đối với dự án Khu đô thị Fujisan Đông Triều (tên pháp lý là dự án Khu dân cư Vĩnh Quang 1), UBND TP Đông Triều đã lần lượt cấp Giấy phép xây dựng số 62/GPXD ngày 01/03/2024 và Giấy phép xây dựng số 528/GPXD ngày 27/09/2024 cho CĐT Kim Long được phép xây dựng công trình hạ tầng khu dân cư và hạng mục xây dựng nhà ở (xây thô và hoàn thiện mặt ngoài 206 căn). Trước đó, Sở xây dựng tỉnh Quảng Ninh cũng đã ban hành thông báo số 1641/SXD-QLN&TTBĐS ngày 24/04/2024 về việc dự án đủ điều kiện huy động vốn. Đây là những căn cứ pháp lý quan trọng để CĐT Kim Long triển khai thực hiện dự án và tiến hành mở bán chính thức. Theo đó, dự án có quy mô hơn 4,5 ha và tổng mức đầu tư dự kiến gần 350 tỷ đồng, với 191 nhà liền kề tiêu chuẩn 5 tầng và 15 nhà biệt thự tiêu chuẩn 3 tầng.

            Với hầu hết khách hàng, khi chọn mua bất kỳ sản phẩm bất động sản nào làm chốn an cư cho gia đình hay với mục đích đầu tư thì uy tín của CĐT và pháp lý của dự án luôn là điều kiện tiên quyết trong các tiêu chí khi đưa lên bàn cân chọn lựa. Với dự án Fujisan Đông Triều, các thủ tục pháp lý đã CĐT được hoàn thiện trước khi chính thức mở bán.

            Cảm Hứng Từ Tinh Hoa Văn Hoá Nhật Bản

            Mong muốn mang một “Nhật Bản thu nhỏ” đặt vào trung tâm kinh tế Mạo Khê của thành phố cửa ngõ phía Tây Quảng Ninh, Fujisan Đông Triều đã chắt lọc những giá trị tinh hoa nhất của xứ sở hoa anh đào để đưa vào thiết kế của các công trình, chuỗi tiện ích và không gian dự án. Toàn bộ thiết kế mang đậm phong cách Nhật Bản, từ cổng chào dự án, cách bố trí các khu tiện ích chú trọng nâng cao sức khoẻ cho đến việc lựa chọn cây xanh tại các khu vực thư giãn như Vườn mộc miên Sakurai, Vườn Thái Cực Quyền, Vườn Kimono ánh trăng…

            Đặc biệt, khu đô thị 4,5 ha còn chú trọng đến việc nuôi dưỡng, chăm sóc sức khoẻ tinh thần và thể chất cho các thế hệ trong một gia đình. Khi mà cuộc sống hiện nay khiến con người phải đối mặt với ngày một nhiều các vấn đề như dịch bệnh, thiên tai, ô nhiễm môi trường… thì xu hướng chăm sóc sức khỏe ngày càng lên ngôi. Việc nâng cao chất lượng cuộc sống đồng nghĩa với việc với nâng cao chất lượng sức khỏe cho bản thân và gia đình và trở thành yếu tố tiên quyết khi lựa chọn chốn an cư …. Fujisan Đông Triều không chỉ đáp ứng nhu cầu thể thao cho bố mẹ tại Khu thể thao Samurai, Sân cầu lông Sakura, Sân bóng rổ… mà còn phục vụ các cư dân nhí với Sân chơi trẻ em Neko, Bể bơi Fuji Aqua… Sau giờ làm việc, học tập căng thẳng, cả gia đình có thể hoà mình vào các không gian thư giãn, nơi sẽ cân bằng cảm xúc và gắn kết các thế hệ.

            Bên cạnh việc chăm chút cho cảnh quan bên ngoài, CĐT Kim Long còn thể hiện sự tinh tế trong từng công trình sản phẩm với tiêu chí ưu tiên sự đơn giản, bố cục rõ ràng, cân đối, hạn chế các chi tiết phức tạp. Một lối kiến trúc tối giản đề cao sự thoải mái, dễ chịu cho chủ sở hữu, vừa ngập tràn ánh sáng tự nhiên nhưng vẫn bảo đảm sự riêng tư, kín đáo.
            ',
        ]);

        TinTuc::create([
            'tai_khoan_id' => 1,
            'danh_muc_id' => 10,
            'tieu_de' => 'The Seahorse: Phú Mỹ Hưng Giữa Lòng Bình Phước',
            'mo_ta' => 'Sự xuất hiện của Khu dân cư trung tâm hành chính Bombo (The Seahorse Central Binh Phuoc) là lời hồi đáp cho khát vọng sống sang ngay tại tọa độ trung tâm hành chính khi kiến tạo nên một “Phú Mỹ Hưng giữa lòng Bình Phước”, nơi hứa hẹn sẽ trở thành niềm kiêu hãnh của tầng lớp thượng lưu vùng đất Bombo huyền thoại.',
            'slug' => 'the-seahorse-phu-my-hung-giua-long-binh-phuoc',
            'image' => 'blog/image16.jpg, blog/image17.jpg',
            'noi_dung' => '
            Phú Mỹ Hưng – nơi kể ra huyền thoại khi biến một vùng đất thành đại đô thị đáng sống, cư dân nơi đây không chỉ được hòa mình vào nhịp điệu phồn hoa đô thị, hơn hết còn là giá trị định danh, niềm tự hào cho cộng đồng cư dân.

            Tại Bù Đăng (Bình Phước) The Seahorse Central Binh Phuoc cũng mang trong mình kỳ vọng như thế, kỳ vọng biến nơi đây thành “Phú Mỹ Hưng giữa lòng Bình Phước”.

            Tọa lạc tại vị trí đắc địa bậc nhất Bombo, ngay trung tâm hành chính, cư dân The Seahorse Central Binh Phuoc không chỉ dễ dàng kết nối đến các tiện ích ngoại khu trong bán kính 2km còn liên kết nhanh chóng đến các vùng phụ cận: Bù Gia Mập, Đăk Nông, Đồng Nai, Chơn Thành… nhờ vị trí đắt giá trên mặt tiền đại lộ ĐT.760, cung đường liên tỉnh đã được mở rộng và nâng cấp vừa qua.

            Hơn hết, The Seahorse Central Binh Phuoc còn sở hữu không gian thơ mộng với dòng suối bao quanh dự án cùng tầm view núi tuyệt đẹp mang đến một không gian sống hoàn hảo, hưởng trọn không khí trong lành hàng ngày.

            The Seahorse Binh Phuoc được quy hoạch theo tiêu chí đô thị hiện đại nhưng vẫn giữ được các nét đặc trưng của vùng đất Bombo anh hùng.

            Nâng Tầm Chuẩn Sống Cho Cộng Đồng Cư Dân Bù Đăng

            Xã Bombo (huyện Bù Đăng, tỉnh Bình Phước) được biết đến là vùng đất anh hùng huyền thoại đi vào thơ ca song hành cùng bảo tàng sóc Bombo được đưa vào di tích Việt Nam. Ngày nay, vùng đất ấy cũng mang trong mình niềm tự hào rất riêng khi là địa phương phát triển bậc nhất trong cụm khu vực.

            Được biết, hiện xã Bombo đang là “hạt nhân” mới của huyện Bù Đăng khi là nơi hội tụ giao thương, văn hóa, y tế, giáo dục của cả cụm xã Bình Minh, Đắk Nhau – Đường 10 với tiềm năng phát triển vượt bậc.

            Bombo là địa phương có nguồn thu ngân sách cao, tốc độ đô thị hóa nhanh nhất huyện. Đến nay, xã chỉ còn 0,3% hộ nghèo. Hệ thống đường liên tỉnh luôn được đầu tư mở rộng, nhựa hóa 100% đường liên thôn và hơn 70% đường nội thôn đã được bê tông hóa.

            Đặc biệt, Bom Bo là xã duy nhất trong khu vực có đầy đủ tiện ích: ngân hàng tài chính, sân vận động, nhà thi đấu đa năng, khu trung tâm thương mại, trạm xá Quân y đang được nâng cấp, trường học các cấp đạt chuẩn, bưu chính – viễn thông khang trang, nhà máy nước sạch và khu dân cư 1/500… Điều đó thu hút lượng lớn dân nhập cư đến sống và làm việc tại đây. Đặc biệt, cận Bombo có khu công nghiệp Minh Hưng 2 đang xây dựng sẽ là lực đẩy thu hút cư dân về Bombo sinh sống, đặc biệt là giới chuyên gia và nhân viên cấp cao cần một không gian sống đẳng cấp.

            Mức sống người dân xã Bombo ngày càng nâng cao, tuy vậy, trên toàn xã chỉ có The Seahorse Binh Phuoc là dự án 1/500 được quy hoạch duy nhất. Để thực hiện sứ mệnh nâng tầm chuẩn sống mới cho cộng đồng cư dân Bombo nói riêng và Bù Đăng nói chung, đây được xem là dự án được xây dựng với hệ tiện ích bậc nhất khu vực để xứng tầm một Phú Mỹ Hưng giữa lòng Bình Phước.

            Tại The Seahorse Central Binh Phuoc, phong cách giao hoà với thiên nhiên được đặc biệt chú trọng, khi mảng xanh, không gian mặt nước được chủ đầu tư cố gắng giữ lại khoảng không cân bằng với công viên cây xanh, khu sinh thái, đường dạo bộ ven hồ… đặc biệt là các trục hành lang an toàn được bố trí cây xanh mang lại không gian thoáng mát.

            Đặc biệt, đây là là dự án hiếm hoi tại Bù Đăng được xây dựng các tiện ích đẳng cấp bậc nhất khu vực từ khu vui chơi – giải trí, coffee ven hồ, câu cá giải trí, khu vui chơi trẻ em…Đặc biệt là khách sạn luxury, trung tâm thương mại, sân đánh Tennis, sân pickleball thời thượng, công viên bốn mùa và tổ hợp bar – club – karaoke đang được xây dựng sẽ lần nữa khẳng định chất sống thời thượng cho cư dân The Seahorse Binh Phuoc.

            The Seahorse Central Binh Phuoc đề cao tính cân bằng giữa sự tiện lợi và giá trị tinh thần. Bước ra khỏi nhà là những con đường quen thuộc, bạn bè người thân quây quần cùng loạt tiện ích ngoại khu đa dạng. Cộng đồng cư dân ở đây còn được thụ hưởng một không gian riêng tư trong khu đô thị compound chuyên biệt cùng một cộng đồng cư dân văn minh, tinh hoa đang dần được hình thành.

            Các “mảnh ghép” như chất lượng không khí, mảng xanh trong khu vực, các tiện ích “đo ni đóng giày” cho các hoạt động cân bằng cuộc sống tại The Seahorse Central Binh Phuoc đang góp phần nâng tầm giá trị sống cho cộng đồng cư dân Bombo.

            The Seahorse Central Binh Phuoc – Phú Mỹ Hưng trong lòng Bình Phước, được xem là khu đô thị phức hợp compound giá rẻ nhất khu vực miền Nam. Với mức giá chỉ từ 5,9tr/m2, ngân hàng hỗ trợ cho vay 80% lãi suất ưu đãi 0% – ân hạn nợ gốc tới 2 năm. Đặc biệt cơ hội bốc thăm xe ô tô điện VF3 (tỷ lệ trúng lên tới 20%)
            ',
        ]);
    }
}
