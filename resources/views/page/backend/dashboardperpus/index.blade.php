@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-10 order-md-1 order-last">
                    <h3>Selamatt Datang Kepala Perpustakaan</h3>
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
                                <div class="stats-icon purple mb-2">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Denda</h6>
                                <h6 class="font-extrabold mb-0"> {{ 'Rp ' . number_format($totalDenda, 0, ',', '.') }}</h6>
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
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Petugas</h6>
                                <h6 class="font-extrabold mb-0">{{ $jumlahPetugas }}</h6>
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
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Table Keterlambatan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Buku</th>
                                    <th class="text-nowrap">Wajib Kembali</th>
                                    <th class="text-nowrap">Tanggal Kembali</th>
                                    <th class="text-nowrap">Terlambat</th>
                                    <th class="text-nowrap">Denda</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($keterlambatan as $item)
                                    <tr>
                                        <td>
                                            {{ $item->peminjaman->anggota->nama_anggota ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->peminjaman->buku->judul_buku ?? '-' }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->peminjaman->wajib_kembali)->format('d-m-Y') }}
                                        </td>

                                        <td>
                                            {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}
                                        </td>

                                        <td>
                                            @php
                                                $telat = \Carbon\Carbon::parse(
                                                    $item->peminjaman->wajib_kembali,
                                                )->diffInDays(\Carbon\Carbon::parse($item->tanggal_kembali), false);
                                            @endphp
                                            {{ $telat > 0 ? $telat . ' hari' : '-' }}
                                        </td>

                                        <td>
                                            {{ $item->denda ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}
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
                        emptyTable: "data kosong"
                    }
                });
            }
        });
    </script>
@endsection
