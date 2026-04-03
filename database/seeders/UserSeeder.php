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
    // KEPALA
    User::firstOrCreate(
        ['email' => 'kepsek@gmail.com'],
        [
            'username' => 'kepalaperpus',
            'role' => 'kepala',
            'password' => Hash::make('123456'),
        ]
    );

    // PETUGAS → sinkron dari tabel petugas
    $petugas = Petugas::all();

    foreach ($petugas as $p) {
        User::firstOrCreate(
            ['email' => $p->email],
            [
                'username' => strtolower(str_replace(' ', '', $p->nama_petugas)),
                'role' => 'petugas',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
}
