<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama_lengkap' => 'Admin',
            'telepon' => '1234567890',
            'alamat' => 'Jl. Admin No.1',
            'rt_rw' => '001/001',
            'qrcode' => 'admin.png',
            'status' => 'aktif',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'nama_lengkap' => 'Petugas',
            'telepon' => '1234567891',
            'alamat' => 'Jl. Petugas No.2',
            'rt_rw' => '002/002',
            'qrcode' => 'petugas.png',
            'status' => 'aktif',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        User::create([
            'nama_lengkap' => 'Pelanggan',
            'telepon' => '1234567892',
            'alamat' => 'Jl. Pelanggan No.3',
            'rt_rw' => '003/003',
            'qrcode' => 'pelanggan.png',
            'status' => 'aktif',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);
        
        User::create([
            'nama_lengkap' => 'Pelanggan 2',
            'telepon' => '1234567893',
            'alamat' => 'Jl. Pelanggan No.3',
            'rt_rw' => '003/003',
            'qrcode' => 'pelanggan.png',
            'status' => 'aktif',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);
    }
}
