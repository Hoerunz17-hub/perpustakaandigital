<?php

use Illuminate\Support\Facades\Route;

// Backend Controllers
use App\Http\Controllers\Backend\AnggotaBackendController;
use App\Http\Controllers\Backend\AuthControllerBackendController;
use App\Http\Controllers\Backend\BukuBackendController;
use App\Http\Controllers\Backend\DashboardKepalaPerpusBackendController;
use App\Http\Controllers\Backend\DashboardPetugasBackendController;
use App\Http\Controllers\Backend\laporanBackendController;
use App\Http\Controllers\Backend\PeminjamanBackendController;
use App\Http\Controllers\Backend\PetugasBackendController;

// Frontend Controllers
use App\Http\Controllers\Frontend\AuthControllerFrontendController;
use App\Http\Controllers\Frontend\BukusayaFrontendController;
use App\Http\Controllers\Frontend\HomeFrontendController;
use App\Http\Controllers\Frontend\PeminjamanFrontendController;
use App\Http\Controllers\Frontend\PengembalianFrontendController;

//
// ==============================
// 🔐 AUTH
// ==============================
//
Route::get('/login', [AuthControllerBackendController::class, 'login'])->name('login');
Route::post('/login', [AuthControllerBackendController::class, 'prosesLogin'])->name('login.proses');

//
// ==============================
// 🔒 BACKEND - PETUGAS
// ==============================
//
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/adminpetugas', [DashboardPetugasBackendController::class, 'index']);

    // Buku
    Route::get('/buku', [BukuBackendController::class, 'index']);
    Route::get('/buku/create', [BukuBackendController::class, 'create']);
    Route::post('/buku/store', [BukuBackendController::class, 'store']);
    Route::get('/buku/edit/{id}', [BukuBackendController::class, 'edit']);
    Route::post('/buku/update/{id}', [BukuBackendController::class, 'update']);
    Route::get('/buku/delete/{id}', [BukuBackendController::class, 'destroy']);
    Route::get('/buku/show/{id}', [BukuBackendController::class, 'show']);
    Route::post('/buku/update-status/{id}', [BukuBackendController::class, 'updateStatus']);
    // Peminjaman
    Route::get('/petugas/peminjaman', [PeminjamanBackendController::class, 'index']);
   Route::get('/peminjaman/acc/{id}', [PeminjamanBackendController::class, 'acc'])
    ->name('peminjaman.acc');

Route::get('/peminjaman/tolak/{id}', [PeminjamanBackendController::class, 'tolak'])
    ->name('peminjaman.tolak');
});
//
// ==============================
// 🔒 BACKEND - KEPALA PERPUS
// ==============================
//

Route::middleware(['auth', 'role:kepala,petugas'])->group(function () {

    Route::get('/anggota', [AnggotaBackendController::class, 'index']);
    Route::get('/anggota/show/{id}', [AnggotaBackendController::class, 'show']);
});

Route::middleware(['auth', 'role:kepala'])->group(function () {

    Route::get('/kepalaperpus', [DashboardKepalaPerpusBackendController::class, 'index']);

    Route::get('/petugas', [PetugasBackendController::class, 'index']);
    Route::get('/petugas/create', [PetugasBackendController::class, 'create']);
    Route::post('/petugas/store', [PetugasBackendController::class, 'store']);
    Route::get('/petugas/edit/{id}', [PetugasBackendController::class, 'edit']);
    Route::post('/petugas/update/{id}', [PetugasBackendController::class, 'update']);
    Route::get('/petugas/delete/{id}', [PetugasBackendController::class, 'destroy']);
    Route::post('/petugas/update-status/{id}', [PetugasBackendController::class, 'updateStatus']);
    Route::get('/laporan', [laporanBackendController::class, 'index']);
});

//
// ==============================
// 🔓 LOGOUT
// ==============================
//
Route::post('/logout', [AuthControllerBackendController::class, 'logout'])->name('logout');

//
// ==============================
// 🌐 FRONTEND
// ==============================
//


Route::get('/', [HomeFrontendController::class, 'index']);
Route::get('/bukusaya', [BukusayaFrontendController::class, 'index']);
Route::get('/buku/show/{id}', [HomeFrontendController::class, 'show']);
Route::get('/anggota/peminjaman', [PeminjamanFrontendController::class, 'index']);
Route::post('/anggota/peminjaman/store', [PeminjamanFrontendController::class, 'store']);
Route::get('/anggota/pengembalian', [PengembalianFrontendController::class, 'index']);
Route::post('/anggota/pengembalian/store', [PengembalianFrontendController::class, 'store']);

Route::post('/loginuser', [AuthControllerFrontendController::class, 'prosesLogin'])->name('login.anggota');
Route::get('/loginuser', [AuthControllerFrontendController::class, 'login']);
Route::post('/logoutuser', [AuthControllerFrontendController::class, 'logout'])->name('logout.anggota');

Route::get('/registrasiuser', [AuthControllerFrontendController::class, 'registrasi']);
Route::post('/registrasiuser', [AuthControllerFrontendController::class, 'store'])->name('register.store');
