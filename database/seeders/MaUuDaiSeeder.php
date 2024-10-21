<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaUuDai;

class MaUuDaiSeeder extends Seeder
{
    public function run()
    {
        MaUuDai::create([
            'code' => 'CODE100K',
            'mo_ta' => 'Giảm giá 100K hóa đơn thanh toán.',
            'so_luong' => 100,
            'gia_tri' => 100000,
            'ngay_ket_thuc' => '2025-10-01',
            'trang_thai' => 1,
        ]);

        MaUuDai::create([
            'code' => 'CODE20PT',
            'mo_ta' => 'Giảm giá 20% hóa đơn thanh toán.',
            'so_luong' => 50,
            'hinh_thuc' => 2,
            'gia_tri' => 20,
            'ngay_ket_thuc' => '2025-10-01',
            'trang_thai' => 1,
        ]);

        MaUuDai::create([
            'code' => 'CODEHETHAN',
            'mo_ta' => 'Code test hết hạn sử dụng',
            'so_luong' => 75,
            'gia_tri' => 200000,
            'ngay_ket_thuc' => '2024-03-31',
        ]);

        MaUuDai::create([
            'code' => 'CODEKOTONTAI',
            'mo_ta' => 'Code chưa tới ngày bắt đầu',
            'so_luong' => 75,
            'gia_tri' => 200000,
            'ngay_ket_thuc' => '2024-03-31',
        ]);

        MaUuDai::create([
            'code' => 'CODEKOSL',
            'mo_ta' => 'Code test không có số lượng',
            'so_luong' => 0,
            'gia_tri' => 200000,
            'ngay_ket_thuc' => '2024-04-30',
        ]);

        MaUuDai::create([
            'code' => 'CODEKOSDD',
            'mo_ta' => 'Code test không sử dụng được | trạng thái = 2',
            'so_luong' => 0,
            'gia_tri' => 200000,
            'ngay_ket_thuc' => '2024-04-30',
            'trang_thai' => 2,
        ]);
    }
}