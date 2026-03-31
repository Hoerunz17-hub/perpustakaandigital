<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =============================
        // 1. KEPALA SEKOLAH
        // =============================
       User::firstOrCreate(
    ['email' => 'kepsek@gmail.com'], // cek berdasarkan email
    [
        'username' => 'kepalaperpus',
        'role' => 'kepala',
        'password' => Hash::make('123456'),
    ]
);

        // =============================
        // 2. PETUGAS (AMBIL DARI TABEL PETUGAS)
        // =============================
        $petugas = Petugas::all();

        foreach ($petugas as $p) {
            User::create([
               'username' => strtolower(str_replace(' ', '', $p->nama_petugas)), // ambil dari tabel petugas
                'email' => $p->email,
                'role' => 'petugas',
                'password' => Hash::make('123456'), // default password
            ]);
        }
    }
}
