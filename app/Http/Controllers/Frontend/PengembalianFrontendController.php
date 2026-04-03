<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengembalianFrontendController extends Controller
{
  public function index(Request $request)
{
    $buku = Buku::where('is_active', 1)->get();

    $selectedBuku = $request->id_buku;

    $peminjaman = null;

   if ($selectedBuku) {
    $peminjaman = Peminjaman::where('id_buku', $selectedBuku)
        ->where('status', 'dipinjam')
        ->whereDoesntHave('pengembalian')
        ->latest()
        ->first();
}
 // 👉 TAMBAHIN DI SINI
    if ($selectedBuku && $peminjaman == null) {
        return redirect('/anggota/pengembalian')
            ->with('success', 'Buku sudah dikembalikan');
    }
    return view("page.frontend.pengembalian.index", compact('selectedBuku', 'buku', 'peminjaman'));
}
  public function store(Request $request)
{
    $request->validate([
        'id_buku' => 'required',
        'tanggal_kembali' => 'required',
    ]);

    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Silakan login terlebih dahulu');
    }

    DB::beginTransaction();

    try {

        $anggotaId = Auth::user()->anggota->id_anggota;

$peminjaman = Peminjaman::where('id_buku', $request->id_buku)
    ->where('id_anggota', $anggotaId) // ✅ BENAR
    ->where('status', 'dipinjam')
    ->whereDoesntHave('pengembalian')
    ->latest()
    ->first();

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        $wajib = Carbon::parse($peminjaman->wajib_kembali);
        $kembali = Carbon::parse($request->tanggal_kembali);

        $selisih = $kembali->diffInDays($wajib, false);

        if ($selisih < 0) {
            $status = 'terlambat';
            $denda = abs($selisih) * 1000;
        } else {
            $status = 'tepat_waktu';
            $denda = 0;
        }

        // 1. simpan pengembalian
        Pengembalian::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_petugas' => 1,
            'tanggal_kembali' => $request->tanggal_kembali,
            'denda' => $denda,
            'status' => $status,
        ]);

        // 2. update status peminjaman
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // 3. update stok buku
        $buku = Buku::find($request->id_buku);
        $buku->stock += 1;
        $buku->save();

        DB::commit();

        return redirect('/anggota/pengembalian')->with('success', 'Pengembalian berhasil');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', $e->getMessage());
    }
}
}
