@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Anggota</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/anggota">Anggota</a></li>
                            <li class="breadcrumb-item active" aria-current="page">detail</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <section class="section">
                <div class="row">

                    <!-- PROFILE -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">

                                @if ($anggota->image)
                                    <img src="{{ asset('storage/' . $anggota->image) }}"
                                        style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $anggota->nama_anggota }}"
                                        style="border-radius:50%;">
                                @endif

                                <h5 class="mt-3">{{ $anggota->nama_anggota }}</h5>
                                <p class="text-muted">{{ $anggota->email }}</p>

                            </div>
                        </div>
                    </div>

                    <!-- DETAIL -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Informasi Anggota</h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-borderless">

                                    <tr>
                                        <th width="200">Nama</th>
                                        <td>: {{ $anggota->nama_anggota }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>: {{ $anggota->email }}</td>
                                    </tr>

                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>: {{ $anggota->jenis_kelamin }}</td>
                                    </tr>

                                    <tr>
                                        <th>Alamat</th>
                                        <td>: {{ $anggota->alamat }}</td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>: {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d-m-Y') }}</td>
                                    </tr>

                                </table>

                                <a href="/anggota" class="btn btn-secondary mt-3">Kembali</a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                History Peminjaman
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>

                                            <th class="text-nowrap">Buku</th>
                                            <th class="text-nowrap">Kode Buku</th>
                                            <th class="text-nowrap">Tanggal Pinjam</th>
                                            <th class="text-nowrap">Wajib Kembali</th>
                                            <th class="text-nowrap">Tanggal Kembali</th>
                                            <th class="text-nowrap">Status</th>
                                            <th class="text-nowrap">Denda</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($history as $index => $anggotas)
                                            <tr>


                                                <td>{{ $anggotas->buku->judul_buku ?? '-' }}</td>

                                                <td>{{ $anggotas->buku->kode_buku ?? '-' }}</td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($anggotas->tanggal_pinjam)->format('d-m-Y') }}
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($anggotas->wajib_kembali)->format('d-m-Y') }}
                                                </td>

                                                <td>
                                                    {{ optional($anggotas->pengembalian)->tanggal_kembali
                                                        ? \Carbon\Carbon::parse(optional($anggotas->pengembalian)->tanggal_kembali)->format('d-m-Y')
                                                        : '-' }}
                                                </td>

                                                <td>
                                                    @if ($anggotas->status == 'menunggu')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif ($anggotas->status == 'dipinjam')
                                                        <span class="badge bg-primary">Dipinjam</span>
                                                    @elseif ($anggotas->status == 'ditolak')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @elseif ($anggotas->status == 'dikembalikan')
                                                        @if ($anggotas->pengembalian && $anggotas->pengembalian->status == 'terlambat')
                                                            <span class="badge bg-danger">Terlambat</span>
                                                        @else
                                                            <span class="badge bg-success">Dikembalikan</span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ optional($anggotas->pengembalian)->denda
                                                        ? 'Rp ' . number_format(optional($anggotas->pengembalian)->denda, 0, ',', '.')
                                                        : '-' }}
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof $ !== 'undefined') {
                    $('#table1').DataTable({
                        destroy: true,
                        language: {
                            emptyTable: "Anggota masih kosongg"
                        }
                    });
                }
            });
        </script>
    @endsection
