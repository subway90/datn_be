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
            'password' => Hash::make('12345678'),
            'born' => '2024-05-31',
            'phone' => '0965279041',
            'role' => 0, //admin
        ]);
        User::create([
            'name' => 'Tester 01',
            'email' => 'test01@gmail.com',
            'password' => Hash::make('12345678'),
            'gender' => 2,
            'address' => 'Tân Thới Nhất, Quận 12,TP Hồ Chí Minh',
            'born' => '2024-07-09',
            'phone' => '0332665391',
        ]);
        User::create([
            'name' => 'Tester 02',
            'email' => 'test02@gmail.com',
            'password' => Hash::make('12345678'),
            'gender' => 3,
            'born' => '2024-05-31',
            'phone' => '0888442652',
        ]);
        User::create([
            'name' => 'Tester 03',
            'email' => 'test03@gmail.com',
            'password' => Hash::make('12345678'),
            'born' => '2024-01-17',
            'gender' => 2,
            'phone' => '0969455222',
        ]);
    }
}
