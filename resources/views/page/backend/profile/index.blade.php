@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="page-heading">
                <h3>Profile Petugas</h3>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <section class="section">
                <div class="row">

                    <!-- ✅ KIRI -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">

                                <!-- FOTO LEBIH BESAR -->
                                <div class="mb-3">
                                    <img class="rounded-circle shadow"
                                        style="width: 150px; height: 150px; object-fit: cover;"
                                        src="{{ auth()->check() && optional(auth()->user()->petugas)->image
                                            ? asset('storage/' . auth()->user()->petugas->image)
                                            : asset('assetsbackend/compiled/jpg/1.jpg') }}">
                                </div>

                                <h5 class="mb-1">{{ auth()->user()->username }}</h5>
                                <p class="text-muted mb-2">{{ auth()->user()->role }}</p>

                                <!-- STATUS BADGE -->
                                <span
                                    class="badge {{ optional(auth()->user()->petugas)->is_active == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ optional(auth()->user()->petugas)->is_active == 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>

                                <hr>

                                <!-- INFO TAMBAHAN -->
                                <div class="d-flex justify-content-around text-center">
                                    <div>
                                        <h6 class="mb-0">{{ auth()->user()->role }}</h6>
                                        <small class="text-muted">Role</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Petugas</h6>
                                        <small class="text-muted">Status Akun</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ✅ KANAN -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Detail Profile</h5>
                            </div>
                            <div class="card-body">

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Username</div>
                                    <div class="col-md-8">: {{ auth()->user()->username }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Email</div>
                                    <div class="col-md-8">: {{ auth()->user()->email ?? '-' }}</div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                                    <div class="col-md-8">: {{ optional(auth()->user()->petugas)->jenis_kelamin ?? '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tanggal Lahir</div>
                                    <div class="col-md-8">
                                        :
                                        {{ optional(auth()->user()->petugas)->tanggal_lahir
                                            ? \Carbon\Carbon::parse(optional(auth()->user()->petugas)->tanggal_lahir)->format('d M Y')
                                            : '-' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Alamat</div>
                                    <div class="col-md-8">: {{ optional(auth()->user()->petugas)->alamat ?? '-' }}</div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
