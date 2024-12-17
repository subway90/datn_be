<?php

namespace Database\Seeders;

use App\Models\ConfigWebsite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ConfigWebsite::create([
            'name' => 'SGHOUSES',
            'description' => 'Chúng tôi là công ty bất động sản hàng đầu, cung cấp dịch vụ chất lượng cao và đáng tin cậy cho khách hàng.',
            'favicon' => 'storage/system/favicon.png',
            'logo' => 'storage/system/logo.png',
            'phone' => '0907789239',
            'email' => 'hotro@sghouses.site',
            'address' => '550 Trường Chinh, Q.12, Hồ Chí Minh',
        ]);
    }
}
