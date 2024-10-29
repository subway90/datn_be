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
            background-color: #fff;
            border-radius: 5px;
            padding: 5% 20%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center; /* Căn giữa nội dung */
        }
        .button {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            color: #fff;
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
    </style>
</head>
<body>
    <div class="container">
        <p>Mật khẩu mới của bạn là: <strong>{{ isset($newPassword ) ? $newPassword : 'xxx yyy' }}</strong></p>
        <small>Hãy đăng nhập để đổi mật khẩu mới !</small>
        <a target="_blank" class="button" href='https://sghouses.vercel.app/login'>Đăng nhập SGHouses</a>
        <div class="footer">
            <p>Vui lòng không chia sẻ mật khẩu này cho ai !</p>
        </div>
    </div>
</body>
</html>