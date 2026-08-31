<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        User::create([
            'name'     => 'Administrator Lab',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // 2. Buat User Petugas
        User::create([
            'name'     => 'Petugas Lab',
            'email'    => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
        ]);

        // 3. Buat User Peminjam (Siswa/Mahasiswa)
        User::create([
            'name'     => 'Siswa Peminjam',
            'email'    => 'peminjam@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'peminjam',
        ]);

        // 4. Buat Kategori Alat
        $elektronik = Category::create(['name' => 'Elektronik & Perangkat']);
        $perkakas   = Category::create(['name' => 'Perkakas Lab']);

        // 5. Buat Data Alat (Tools)
        Tool::create([
            'name'        => 'Oscilloscope Digital',
            'category_id' => $elektronik->id,
            'stock'       => 5,
        ]);

        Tool::create([
            'name'        => 'Solder Station 60W',
            'category_id' => $perkakas->id,
            'stock'       => 10,
        ]);

        Tool::create([
            'name'        => 'Multimeter Digital',
            'category_id' => $elektronik->id,
            'stock'       => 0, // Stok habis untuk pengujian tombol disabled
        ]);
    }
}