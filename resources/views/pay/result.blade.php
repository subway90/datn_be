<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Thanh Toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body class="container-fluid">
    <div class="container text-center mt-5">
        <div class="text-center">
            <div class="text-warning">Thông báo Sghouses</div>
            <div class="h3 text-success mt-1">Thanh toán hóa đơn thành công</div>
            <button class="btn btn-sm btn-outline-secondary" onclick="window.location.href=`{{ENV('DOMAIN_FE').'/profile/history'}}`">Quay về trang chủ</button>
        </div>
        <div class="col-12 row justify-content-center mt-5">
            <div class="col-6">
                <table class="table table-primary table-hover col-6">
                    <thead>
                        <tr>
                            <th class="py-3" colspan="2">Chi tiết hóa đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mã hóa đơn</td>
                            <td> {{ $ma_giao_dich }} </td>
                        </tr>
                        <tr>
                            <td>Số tiền</td>
                            <td> {{ number_format($so_tien,0,'.',',') }} <sup>vnđ</sup></td>
                        </tr>
                        <tr>
                            <td>Nội dung</td>
                            <td> {{ $noi_dung }} </td>
                        </tr>
                        <tr>
                            <td>Ngày giao dịch</td>
                            <td> {{ $ngay_giao_dich }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>