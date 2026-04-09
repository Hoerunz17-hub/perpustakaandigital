<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanBackendController extends Controller
{
    public function index(){
      $data = Peminjaman::with(['anggota', 'buku', 'pengembalian'])->get();

    return view('page.backend.peminjaman.index', compact('data'));
    }

  public function acc($id)
{

    $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
        return back()->with('error', 'Peminjaman sudah diproses!');
    }


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

    // 🔥 ambil waktu saat ACC
    $tanggalAcc = Carbon::now();

    // 📚 lama pinjam (misal 3 hari)
    $lama = 3;

    $peminjaman->update([
        'status' => 'dipinjam',
        'id_petugas' => $petugas->id_petugas,

        // ✅ set tanggal pinjam saat ACC
        'tanggal_pinjam' => $tanggalAcc,

        // ✅ hitung wajib kembali dari ACC
        'wajib_kembali' => $tanggalAcc->copy()->addDays($lama),
    ]);

    // 🔽 kurangi stok
    $buku->decrement('stock');
});

    return back()->with('success', 'Peminjaman disetujui');
}
public function tolak($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
      if ($peminjaman->status !== 'menunggu') {
        return back()->with('error', 'Peminjaman sudah diproses!');
    }
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
public function konfirmasiKembali($id)
{
    $peminjaman = Peminjaman::with('buku')->findOrFail($id);

    DB::transaction(function () use ($peminjaman) {

        // ubah status jadi dikembalikan
        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        // tambah stok buku
        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stock');
        }
    });

    return back()->with('success', 'Pengembalian dikonfirmasi');
}
public function tolakKembali($id)
{
    $peminjaman = Peminjaman::with('pengembalian')->findOrFail($id);

    DB::transaction(function () use ($peminjaman) {

        // ✅ status peminjaman tetap DIPINJAM
        $peminjaman->update([
            'status' => 'dipinjam'
        ]);

        // ✅ status pengembalian HARUS ditolak
        if ($peminjaman->pengembalian) {
            $peminjaman->pengembalian->update([
                'status' => 'ditolak'
            ]);
        }

    });

    return back()->with('success', 'Pengembalian ditolak');
}

public function show($id)
{
    $peminjaman = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
        ->findOrFail($id);

    return view('page.backend.peminjaman.detail', compact('peminjaman'));
}

public function destroy($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // optional: validasi biar aman
    if ($peminjaman->status == 'dipinjam') {
        return back()->with('error', 'Tidak bisa hapus, masih dipinjam!');
    }

    $peminjaman->delete();

    return back()->with('success', 'Data berhasil dihapus');
}
}
