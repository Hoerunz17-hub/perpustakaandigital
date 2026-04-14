<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

// 📚 lama pinjam 7 hari
$lama = 7;

$peminjaman->update([
    'status' => 'dipinjam',
    'id_petugas' => $petugas->id_petugas,

    'tanggal_pinjam' => $tanggalAcc,

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
    $kondisi = optional($peminjaman->pengembalian)->kondisi_buku;

    if ($kondisi != 'hilang') {
        $peminjaman->buku->increment('stock');
    }
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
public function struk($id)
{
    $first = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
        ->findOrFail($id);

    if ($first->status != 'dikembalikan') {
        return back()->with('error', 'Struk hanya setelah dikembalikan!');
    }

    //  pakai created_at (waktu real)
    $waktu = \Carbon\Carbon::parse(optional($first->pengembalian)->created_at);

    //  range 1 menit (AMAN)
    $start = $waktu->copy()->subMinute();
    $end   = $waktu->copy()->addMinute();

    $data = Peminjaman::with(['anggota', 'buku', 'pengembalian'])
        ->where('id_anggota', $first->id_anggota)
        ->where('status', 'dikembalikan')
        ->whereHas('pengembalian', function ($q) use ($start, $end) {
            $q->whereBetween('created_at', [$start, $end]);
        })
        ->get();

    $petugas = optional(Auth::user()->petugas)->nama_petugas ?? '-';

    $pdf = Pdf::loadView('page.backend.peminjaman.struk', [
        'data' => $data,
        'anggota' => $first->anggota,
        'petugas' => $petugas
    ])->setPaper([0, 0, 226.77, 800], 'portrait');

    return $pdf->stream('struk.pdf');
}
}
