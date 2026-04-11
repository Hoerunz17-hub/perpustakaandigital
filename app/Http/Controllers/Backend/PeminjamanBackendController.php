<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanBackendController extends Controller
{
    public function index(){
      $data = Peminjaman::with(['anggota', 'buku', 'pengembalian'])->get();

    return view('page.backend.peminjaman.index', compact('data'));
    }

  public function acc($id)
{

    $peminjaman = Peminjaman::findOrFail($id);

    $buku = Buku::find($peminjaman->id_buku);
    if (!$buku) {
        return back()->with('error', 'Data buku tidak ditemukan!');
    }

    if ($buku->stock <= 0) {
        return back()->with('error', 'Stock buku habis!');
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if (!$user) {
        return back()->with('error', 'User belum login!');
    }

    $petugas = $user->petugas;

    if (!$petugas) {
        return back()->with('error', 'Data petugas tidak ditemukan!');
    }

    DB::transaction(function () use ($peminjaman, $buku, $petugas) {
        $peminjaman->update([
            'status' => 'dipinjam',
            'id_petugas' => $petugas->id_petugas
        ]);

        $buku->decrement('stock');
    });

    return back()->with('success', 'Peminjaman disetujui');
}
public function tolak($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

 $user = Auth::user();

if (!$user) {
    return back()->with('error', 'User belum login!');
}

$petugas = $user->petugas;

if (!$petugas) {
    return back()->with('error', 'Data petugas tidak ditemukan!');
}

    $peminjaman->update([
        'status' => 'ditolak',
        'id_petugas' => $petugas->id_petugas
    ]);

    return back()->with('success', 'Peminjaman ditolak');
}

public function show($id)
{
    $peminjaman = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
        ->findOrFail($id);

    return view('page.backend.peminjaman.detail', compact('peminjaman'));
}
}
