<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Admin
        User::create([
            'username' => 'admin',
            'role'     => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Membuat Kasir
        User::create([
            'username' => 'kasir',
            'role'     => 'kasir',
            'password' => Hash::make('kasir123'),
        ]);
    }
}   