@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Buku</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/buku">Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">

                    {{-- COVER --}}
                    <div class="col-md-3 text-center">
                        @if ($data->cover)
                            <img src="{{ asset('storage/' . $data->cover) }}" class="img-fluid rounded"
                                style="max-height: 300px;">
                        @else
                            <img src="https://via.placeholder.com/200x250?text=No+Cover" class="img-fluid rounded">
                        @endif
                    </div>

                    {{-- DETAIL --}}
                    <div class="col-md-9">

                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Judul Buku</th>
                                <td>: {{ $data->judul_buku }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>: {{ date('d-m-Y', strtotime($data->tahun_terbit)) }}</td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>: {{ $data->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>: {{ $data->kategori }}</td>
                            </tr>
                            <tr>
                                <th>Stock</th>
                                <td>: {{ $data->stock }}</td>
                            </tr>
                            <tr>
                                <th>Kode Buku</th>
                                <td>: {{ $data->kode_buku }}</td>
                            </tr>
                        </table>

                        <hr>

                        <h5 class="fw-bold">Deskripsi Buku</h5>
                        <p class="text-muted">
                            {{ $data->deskripsi_buku }}
                        </p>

                    </div>
                </div>

                <div class="mt-3">
                    <a href="/buku" class="btn btn-light-secondary me-1 mb-1">
                        Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
