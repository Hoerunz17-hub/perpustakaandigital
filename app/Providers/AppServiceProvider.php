<?php

namespace App\Providers;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    View::composer('*', function ($view) {

        if (Auth::check() && Auth::user()->role == 'petugas') {

            // 🔢 COUNT NOTIF
            $totalNotif = DB::table('peminjaman')
                ->whereIn('status', ['menunggu', 'menunggu_pengembalian'])
                ->count();

            // 📋 DATA NOTIF + JOIN BUKU
           $notifData = DB::table('peminjaman')
    ->join('buku', 'peminjaman.id_buku', '=', 'buku.id_buku')
    ->join('anggota', 'peminjaman.id_anggota', '=', 'anggota.id_anggota')
    ->whereIn('peminjaman.status', ['menunggu', 'menunggu_pengembalian'])
    ->select(
        'peminjaman.id_peminjaman',
        'peminjaman.status',
        'buku.judul_buku',
        'anggota.nama_anggota as nama_anggota'
    )
    ->orderBy('peminjaman.created_at', 'desc')
    ->limit(5)
    ->get();

            $view->with([
                'totalNotif' => $totalNotif,
                'notifData' => $notifData
            ]);
        }
    });
}
}
