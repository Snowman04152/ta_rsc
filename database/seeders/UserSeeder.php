<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'FE',
                'nama_lengkap' => 'Front End Developer',
                'telp_user' => 'Front End Developer',
                'email' => 'admin@admin',
                'tanggal_lahir' => '12',
                'password' => bcrypt('1234')
            ]
        ]);

    }
}
