<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Nguyễn Minh Hiếu',
            'email' => 'nguyenhieu3105@gmail.com',
            'avatar' => 'avatar/img0.jpg',
            'password' => Hash::make('12345678'),
            'born' => '2024-05-31',
            'phone' => '0965279041',
            'role' => 0, //admin
        ]);
        User::create([
            'name' => 'Mạnh Tường',
            'email' => 'tuonghtmps33160@fpt.edu.vn',
            'avatar' => 'avatar/img1.png',
            'password' => Hash::make('12345678'),
            'gender' => 2,
            'address' => 'Tân Thới Nhất, Quận 12,TP Hồ Chí Minh',
            'born' => '2024-07-09',
            'phone' => '0332665391',
        ]);
        User::create([
            'name' => 'Tester 02',
            'email' => 'dnhieu2530@gmail.com',
            'password' => Hash::make('12345678'),
            'gender' => 3,
            'born' => '2024-05-31',
            'phone' => '0888442652',
        ]);
        User::create([
            'name' => 'Tester 03',
            'email' => 'tannnps33351@fpt.edu.vn',
            'password' => Hash::make('12345678'),
            'born' => '2024-01-17',
            'gender' => 2,
            'phone' => '0969455222',
        ]);
        User::create([
            'name' => 'Tester 04',
            'email' => 'hieunmps33151@fpt.edu.vn',
            'password' => Hash::make('12345678'),
            'born' => '2024-01-17',
            'gender' => 2,
            'phone' => '0969455222',
        ]);
        User::create([
            'name' => 'Võ Hữu Đạt',
            'email' => 'vohuudat282224@gmail.com',
            'password' => Hash::make('123456789'),
            'born' => '2024-02-28',
            'gender' => 2,
            'phone' => '0123456789',
            'role' => 0, //admin
        ]);
    }
}
