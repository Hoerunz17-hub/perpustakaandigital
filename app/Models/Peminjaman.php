<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $guarded = [];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'wajib_kembali' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function buku()
{
    return $this->belongsTo(Buku::class, 'id_buku');
}

public function anggota()
{
    return $this->belongsTo(Anggota::class, 'id_anggota');
}
public function petugas()
{
    return $this->belongsTo(Petugas::class, 'id_petugas');
}
public function pengembalian()
{
    return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id_peminjaman');
}
}

