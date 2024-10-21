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
            'role' => 0,
        ]);
        User::create([
            'name' => 'Tester 01',
            'email' => 'test01@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
