@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Selamatt Datang Petugass</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon red mb-2">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Buku</h6>
                                <h6 class="font-extrabold mb-0">{{ $jumlahBuku }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon blue mb-2">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Anggota</h6>
                                <h6 class="font-extrabold mb-0">{{ $jumlahAnggota }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon green mb-2">
                                    <i class="fas fa-book-open"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Buku Dipinjam</h6>
                                <h6 class="font-extrabold mb-0">{{ $bukuDipinjam }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="fas fa-undo"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Buku dikembalikan</h6>
                                <h6 class="font-extrabold mb-0">{{ $bukuDikembalikan }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Peminjaman Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Buku dipinjam</th>
                                    <th class="text-nowrap">Kode Buku</th>
                                    <th class="text-nowrap">Tanggal Pinjam</th>
                                    <th class="text-nowrap">Tanggal Kembali</th>
                                    <th class="text-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($historyPeminjaman as $item)
                                    <tr>
                                        <td class="text-nowrap">
                                            {{ $item->anggota->nama_anggota ?? '-' }}
                                        </td>

                                        <td class="text-nowrap">
                                            {{ $item->buku->judul_buku ?? '-' }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $item->buku->kode_buku ?? '-' }}
                                        </td>

                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            {{ optional($item->pengembalian)->tanggal_kembali
                                                ? \Carbon\Carbon::parse($item->pengembalian->tanggal_kembali)->format('d-m-Y')
                                                : '-' }}
                                        </td>

                                        <td>
                                            @php
                                                $status = optional($item->pengembalian)->status ?? $item->status;
                                            @endphp

                                            @if ($status == 'menunggu')
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif ($status == 'dipinjam')
                                                <span class="badge bg-primary">Dipinjam</span>
                                            @elseif ($status == 'dikembalikan')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @elseif ($status == 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @elseif ($status == 'ditolak')
                                                <span class="badge bg-secondary">Ditolak</span>
                                            @elseif ($status == 'tepat_waktu')
                                                <span class="badge bg-success">Tepat Waktu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <style>
        #table1 th,
        #table1 td {
            vertical-align: middle !important;
        }

        #table1 th:last-child,
        #table1 td:last-child {
            text-align: center;
        }

        #table1 td:last-child {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined') {
                $('#table1').DataTable({
                    destroy: true,
                    language: {
                        emptyTable: "Peminjaman masih kosong"
                    }
                });
            }
        });
    </script>
@endsection
