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
            'name' => 'Quản trị viên',
            'email' => 'nguyenhieu3105@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 0,
        ]);
        User::create([
            'name' => 'Tester 01',
            'email' => 'test01@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Tester 02',
            'email' => 'test02@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'name' => 'Tester 03',
            'email' => 'test03@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
