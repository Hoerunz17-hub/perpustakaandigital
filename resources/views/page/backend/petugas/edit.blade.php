@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Form Edit Petugas</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/petugas">Petugas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Edit Petugas</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form action="/petugas/update/{{ $data->id_petugas }}" method="POST"
                                    enctype="multipart/form-data" class="form" data-parsley-validate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="nama_petugas" class="form-label">Nama</label>
                                                <input type="text" id="nama_petugas" class="form-control"
                                                    placeholder="Nama Petugas" name="nama_petugas"
                                                    data-parsley-required="true" / value="{{ $data->nama_petugas }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="last-name-column" class="form-label">Jenis Kelamain</label>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="jenis_kelamin">
                                                        <option value="" selected disabled>Jenis Kelamin</option>
                                                        <option value="laki-laki"
                                                            {{ $data->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                                            Laki-Laki</option>
                                                        <option value="perempuan"
                                                            {{ $data->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                                <input type="date" id="tanggal_lahir" class="form-control"
                                                    name="tanggal_lahir" data-parsley-required="true" /
                                                    value="{{ $data->tanggal_lahir }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ $data->alamat }}</textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                    placeholder="Email" data-parsley-required="true"
                                                    value="{{ $data->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="image" class="form-label">Foto</label>

                                                <input class="form-control" type="file" id="image" name="image"
                                                    multiple>
                                                @if ($data->image)
                                                    <img src="{{ asset('storage/' . $data->image) }}" width="150"
                                                        height="150" class="mb-2"
                                                        style="object-fit: cover; border-radius: 50%; border: 3px solid #0d6efd;">
                                                @endif
                                                <small class="text-muted">Kosongkan jika tidak ingin mengganti
                                                    cover</small>
                                            </div>
                                        </div>

                                        <div class="col-12">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-warning me-1 mb-1">
                                                Update
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
