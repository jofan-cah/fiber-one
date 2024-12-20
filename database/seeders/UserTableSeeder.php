<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('user_levels')->insert([
            [

                'user_level_id' => 'LVL250101001', // contoh user level ID
                'user_name' => 'Admin',
                'user_description' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_level_id' => 'LVL250101002',
                'user_name' => 'Noc',
                'user_description' => 'Network Operational Center',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_level_id' => 'LVL250101003',
                'user_name' => 'Sales',
                'user_description' => 'Sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        // Menambahkan data pengguna pertama
        DB::table('users')->insert([
            'user_id' => 'USR250101001',
            'username' => 'admin',
            'full_name' => 'admin123',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Gunakan Hash::make untuk menyimpan password yang aman
            'user_level_id' => 'LVL250101001', // Pastikan '1' adalah id yang valid di tabel 'user_levels'
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menambahkan data pengguna kedua
        DB::table('users')->insert([
            'user_id' => 'USR250101002',
            'username' => 'user1',
            'full_name' => 'User One',
            'email' => 'user1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'user_level_id' => 'LVL250101002', // Sesuaikan dengan level pengguna yang ada
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menambahkan data pengguna ketiga
        DB::table('users')->insert([
            'user_id' => 'USR250101003',
            'username' => 'user2',
            'full_name' => 'User Two',
            'email' => 'user2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'user_level_id' => 'LVL250101003', // Sesuaikan dengan level pengguna yang ada
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
