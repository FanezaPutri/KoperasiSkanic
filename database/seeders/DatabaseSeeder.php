<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Penjaga Koperasi
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Penjaga Koperasi',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Contoh Pembeli (Siswa)
        User::firstOrCreate(
            ['username' => 'siswa'],
            [
                'name' => 'Siswa Skanic',
                'password' => Hash::make('siswa123'),
                'role' => 'buyer',
            ]
        );

        // 3. Kategori Sesuai Permintaan
        $categories = [
            ['name' => 'Makanan & Minuman', 'type' => 'physical'],
            ['name' => 'Alat Tulis', 'type' => 'physical'],
            ['name' => 'Atribut Sekolah', 'type' => 'physical'],
            ['name' => 'Kebersihan', 'type' => 'physical'],
            ['name' => 'Obat', 'type' => 'physical'],
            ['name' => 'Jasa E-Wallet', 'type' => 'service'],
            ['name' => 'Pulsa', 'type' => 'service'],
            ['name' => 'Photocopy', 'type' => 'service'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                ]
            );
        }

        // 4. Populate Produk & Layanan Jasa
        $this->call(ProductSeeder::class);
    }
}
