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
    <div class="container mt-3">
        <div class="text-center">
            <div class="h3 text-warning">Kết Quả Thanh Toán</div>
         <button class="btn btn-sm btn-outline-secondary" onclick="window.location.href=`https://sghouses.vercel.app`">Quay về trang chủ</button>
         <div class="mt-3" id="result"></div>
        </div>
        <table class="table" id="details" style="display:none;">
            <thead>
                <tr>
                    <th>Tham Số</th>
                    <th>Giá Trị</th>
                </tr>
            </thead>
            <tbody id="details-body"></tbody>
        </table>
    </div>

    <script>
        // Lấy thông tin từ URL
        const params = new URLSearchParams(window.location.search);
        const txnRef = params.get('vnp_TxnRef');
        const responseCode = params.get('vnp_ResponseCode');
        const resultDiv = document.getElementById('result');

        if (responseCode === '00') {
            resultDiv.innerHTML = `<p class="text-success">Thanh toán thành công cho đơn hàng: ${txnRef}</p>`;
        } else {
            resultDiv.innerHTML = `<p class="text-danger">Thanh toán thất bại. Mã phản hồi: ${responseCode}</p>`;
        }

        // Hiển thị tất cả các tham số
        const detailsBody = document.getElementById('details-body');
        params.forEach((value, key) => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${key}</td><td>${value}</td>`;
            detailsBody.appendChild(row);
        });

        // Hiện bảng thông tin
        document.getElementById('details').style.display = 'table';
    </script>
</body>

</html>
