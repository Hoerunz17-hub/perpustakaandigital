@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Form Tambah Buku</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/buku">Buku</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                            <h4 class="card-title">Form Tambah Buku</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/buku/store" method="POST" enctype="multipart/form-data"
                                    data-parsley-validate>
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="judul_buku" class="form-label">Judul Buku</label>
                                                <input type="text" id="judul_buku" class="form-control"
                                                    placeholder="judul_buku" name="judul_buku"
                                                    data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="penulis" class="form-label">Penulis</label>
                                                <input type="text" id="penulis" class="form-control"
                                                    placeholder="penulis" name="penulis" data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="stock" class="form-label">Stock</label>
                                                <input type="number" id="stock" class="form-control" name="stock"
                                                    data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                                <input type="date" id="tahun_terbit" class="form-control"
                                                    name="tahun_terbit" placeholder="tahun_terbit"
                                                    data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kategori" class="form-label">Kategori</label>
                                                <input type="text" id="kategori" class="form-control"
                                                    placeholder="kategori" name="kategori" data-parsley-required="true" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="deskripsi_buku" class="form-label">Deskripsi
                                                    Buku</label>
                                                <textarea class="form-control" id="deskripsi_buku" rows="2" name="deskripsi_buku" placeholder="Deskripsi Buku"></textarea>
                                            </div>

                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="cover" class="form-label">Cover</label>
                                                <input class="form-control" type="file" id="cover" name="cover">
                                            </div>
                                        </div>

                                        <div class="col-12">

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Submit
                                            </button>
                                            <a href="/buku" class="btn btn-light-secondary me-1 mb-1">
                                                Kembali
                                            </a>
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
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'ada kesalahan kayaknya'
                });
            });
        </script>
    @endif
@endsection
