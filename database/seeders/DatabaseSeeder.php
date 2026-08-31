<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin (Bisa Akses Filament Panel)
        User::create([
            'name'     => 'Administrator Lab',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // 2. Akun Petugas (Bisa Akses Filament Panel)
        User::create([
            'name'     => 'Petugas Lab',
            'email'    => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);

        // 3. Akun Peminjam / User (Hanya Akses Frontend Utama)
        User::create([
            'name'     => 'Siswa Peminjam',
            'email'    => 'peminjam@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'peminjam',
        ]);
    }
}