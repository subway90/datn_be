<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DangKyNhanTin;
use Ramsey\Uuid\Uuid;

class DangKyNhanTInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DangKyNhanTin::create([
            'email' => 'vohuudat282224@gmail.com',
            'token_verify'=> Uuid::uuid4()->toString(),
            'trang_thai' => 1,
            'created_at' => '2024-05-12 15:41:34',
            'updated_at' => '2024-05-12 15:49:22',
        ]);

        DangKyNhanTin::create([
            'email' => 'vutrumobile@gmail.com',
            'token_verify'=> Uuid::uuid4()->toString(),
            'trang_thai' => 1,
            'created_at' => '2024-05-17 13:15:42',
            'updated_at' => '2024-05-17 13:22:22',
        ]);

        DangKyNhanTin::create([
            'email' => 'nguyennhattan2328@gmail.com',
            'token_verify'=> Uuid::uuid4()->toString(),
            'trang_thai' => 1,
            'created_at' => '2024-06-22 09:23:34',
            'updated_at' => '2024-06-22 09:24:09',
        ]);

        DangKyNhanTin::create([
            'email' => 'lebela02999@gmail.com',
            'token_verify'=> Uuid::uuid4()->toString(),
            'trang_thai' => 1,
            'created_at' => '2024-07-21 21:59:22',
            'updated_at' => '2024-07-21 22:05:02',
        ]);
    }
}
