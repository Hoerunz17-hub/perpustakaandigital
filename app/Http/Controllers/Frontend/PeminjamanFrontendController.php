<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanFrontendController extends Controller
{
    public function index(Request $request)
{
    $buku = Buku::where('is_active', 1)->get();

    // ambil id buku dari query string (?id_buku=...)
    $selectedBuku = $request->id_buku;

    return view('page.frontend.peminjaman.index', compact('buku', 'selectedBuku'));

}
public function store(Request $request)
{
    $anggotaId = Auth::user()->anggota->id_anggota;

   DB::beginTransaction();

    try {

        // 🔥 cek jumlah buku yang masih aktif
        $totalPinjam = Peminjaman::where('id_anggota', $anggotaId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($totalPinjam >= 3) {
            return back()->with('error', 'Maksimal peminjaman hanya 3 buku, silakan kembalikan buku terlebih dahulu.');
        }

        // optional: cek buku tersedia
        $buku = Buku::findOrFail($request->id_buku);

        if ($buku->stock <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // SIMPAN PEMINJAMAN
        Peminjaman::create([
            'id_petugas' => null,
            'id_buku' => $request->id_buku,
            'id_anggota' => $anggotaId,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'wajib_kembali' => $request->wajib_kembali,
            'status' => 'menunggu'
        ]);

       DB::commit();

        return redirect('/anggota/peminjaman')->with('success', 'Pengajuan peminjaman berhasil, tunggu konfirmasi petugas');

    } catch (\Exception $e) {
      DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}
}
