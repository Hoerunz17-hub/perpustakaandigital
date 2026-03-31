@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Petugas</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/petugas">Petugas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">

                    {{-- FOTO --}}
                    <div class="col-md-3 text-center">
                        @if ($data->image)
                            <img src="{{ asset('storage/' . $data->image) }}" class="img-fluid rounded"
                                style="max-height: 250px;">
                        @else
                            <img src="https://via.placeholder.com/200x250?text=No+Image" class="img-fluid rounded">
                        @endif
                    </div>

                    {{-- DETAIL --}}
                    <div class="col-md-9">

                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Nama Petugas</th>
                                <td>: {{ $data->nama_petugas }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>: {{ $data->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>: {{ date('d-m-Y', strtotime($data->tanggal_lahir)) }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>: {{ $data->email }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $data->alamat }}</td>
                            </tr>
                        </table>

                    </div>
                </div>

                <div class="mt-3">
                    <a href="/petugas" class="btn btn-light-secondary">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    @endsection
