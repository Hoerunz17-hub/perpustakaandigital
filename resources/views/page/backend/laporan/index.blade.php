@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Table Laporan</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Laporan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-flex justify-content-between gap-2 flex-wrap">
                        <div>
                            Table Laporan
                        </div>
                        <a href="#" class="btn btn-primary d-flex align-items-center justify-content-center"
                            style="padding:6px 12px;">
                            <iconify-icon icon="mdi:printer" width="20" height="20"></iconify-icon>
                        </a>
                    </h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Buku Dipinjam</th>
                                    <th class="text-nowrap">Tanggal Pinjam</th>
                                    <th class="text-nowrap">Tanggal Kembali</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-nowrap">1</td>
                                    <td class="text-nowrap">Foto</td>
                                    <td class="text-nowrap">17-05026</td>
                                    <td class="text-nowrap"> tere liye</td>
                                    <td class="text-nowrap"> 0182</td>
                                    <td class="text-nowrap">
                                        <span class="badge bg-light-danger">Terlambat</span>
                                    </td>
                                    <td class="text-nowrap">
                                        Rp 3000
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
