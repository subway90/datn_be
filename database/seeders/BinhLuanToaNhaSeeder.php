<?php

namespace Database\Seeders;

use App\Models\BinhLuanToaNha;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BinhLuanToaNhaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BinhLuanToaNha::create([
            'tai_khoan_id' => 2,
            'toa_nha_id' => 1,
            'noi_dung' => 'Còn phòng này không nhỉ',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 4,
            'toa_nha_id' => 1,
            'noi_dung' => 'Đầy đủ tiện nghi quá !',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 3,
            'toa_nha_id' => 1,
            'noi_dung' => 'Quá đẳng cấp và giá hợp lí',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 4,
            'toa_nha_id' => 2,
            'noi_dung' => 'Giá cả hợp lí, đầy đủ tiện nghi. Nên ở ae ạ',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 3,
            'toa_nha_id' => 3,
            'noi_dung' => 'Còn phòng không QTV ơi',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 3,
            'toa_nha_id' => 2,
            'noi_dung' => 'Tôi muốn thuê phòng này',
            'trang_thai' => 1,
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 3,
            'toa_nha_id' => 1,
            'noi_dung' => 'Tôi muốn thuê phòng này, giá cả sao nhỉ',
        ]);

        BinhLuanToaNha::create([
            'tai_khoan_id' => 3,
            'toa_nha_id' => 2,
            'noi_dung' => 'Còn phòng ko ?',
        ]);
    }
}
