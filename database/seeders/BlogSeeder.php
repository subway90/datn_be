<?php

namespace Database\Seeders;

use App\Models\Binh_luan_tin_tuc;
use App\Models\Danh_muc_tin_tuc;
use App\Models\Tin_tuc;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Thêm 3 bản ghi vào bảng Tin_tuc
        Tin_tuc::create([
            'id_tai_khoan' => '1',
            'id_danh_muc' => '1',
        ]);
        
        Tin_tuc::create([
            'id_tai_khoan' => '2',  
            'id_danh_muc' => '2',    
        ]);
        
        Tin_tuc::create([
            'id_tai_khoan' => '3',  
            'id_danh_muc' => '3',    
        ]);
        
        // Thêm 3 bản ghi vào bảng Danh_muc_tin_tuc
        Danh_muc_tin_tuc::create([
            'ten_danh_muc' => 'Nha tro 1',
            'trang_thai' => 'con trong',
        ]);
        
        Danh_muc_tin_tuc::create([
            'ten_danh_muc' => 'Nha tro 2',  
            'trang_thai' => 'con trong',
        ]);
        
        Danh_muc_tin_tuc::create([
            'ten_danh_muc' => 'Nha tro 3',  
            'trang_thai' => 'con trong',
        ]);
        
        // Thêm 3 bản ghi vào bảng Binh_luan_tin_tuc
        Binh_luan_tin_tuc::create([
            'id_tai_khoan' => '1',
            'id_bai_viet' => '1', 
            'noi_dung' => 'My house so pretty',
            'trang_thai' => 'con trong',
        ]);
        
        Binh_luan_tin_tuc::create([
            'id_tai_khoan' => '2',
            'id_bai_viet' => '2', 
            'noi_dung' => 'Nice view from the window', 
            'trang_thai' => 'con trong',
        ]);
        
        Binh_luan_tin_tuc::create([
            'id_tai_khoan' => '3',  
            'id_bai_viet' => '3',
            'noi_dung' => 'I love this place!', 
            'trang_thai' => 'con trong',
        ]);
    }
}

