<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mật khẩu mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Chiều cao bằng chiều cao của viewport */
        }
        strong {
            color: #D74400;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 5% 20%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center; /* Căn giữa nội dung */
        }
        .button {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            color: #ffffff;
            background-color: #00008b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Bỏ gạch chân */
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        small {
            margin: 2px 0;
            display: block; /* Đảm bảo nhỏ hiển thị trên dòng mới */
        }
        .domain {
            color:#EF4444
        }
        .hotline {
            color:#d32d2d
        }
        .website{
            text-decoration: none;
            color: #00008b;

        }
    </style>
</head>
<body>
    <div class="container">
        <p>Cảm ơn bạn đã xác nhận đăng kí nhận tin từ <span class="domain">Sghouses</span>.</p>
        <small>Đây chỉ là thư thông báo, vui lòng không trả lời lại.</small>
        <div class="footer">
            <hr style="margin-top:50px">
            <p>Cho thuê phòng trọ, căn hộ SGHOUSES</p>
            <a target="_blank" href="{{ ENV('DOMAIN_FE') }}" class="website">Truy cập website Sghouses</a>
            <p class="hotline">Hotline: 0907.789.239</p>
        </div>
    </div>
</body>
</html>