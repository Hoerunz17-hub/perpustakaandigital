@extends('layout.backend.app')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Table Peminjaman</h3>
                    <p class="text-subtitle text-muted">Navbar will appear on the top of the page.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Peminjaman</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Table Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Buku Yang Dipinjam</th>
                                    <th class="text-nowrap">Tanggal Pinjam</th>
                                    <th class="text-nowrap">Wajib Kembali</th>
                                    <th class="text-nowrap">Tanggal Kembali</th>
                                    <th class="text-nowrap">Denda</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>

                            </thead>
                            <tbody>
                                @forelse ($data as $pinjams)
                                    <tr>
                                        <td class="text-nowrap">{{ $pinjams->id_peminjaman }}</td>
                                        <td class="text-nowrap">{{ $pinjams->anggota->nama_anggota ?? '-' }}</td>
                                        <td class="text-nowrap">{{ $pinjams->buku->judul_buku ?? '-' }}</td>
                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($pinjams->tanggal_pinjam)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ \Carbon\Carbon::parse($pinjams->wajib_kembali)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>
                                            {{ optional($pinjams->pengembalian)->tanggal_kembali
                                                ? \Carbon\Carbon::parse(optional($pinjams->pengembalian)->tanggal_kembali)->translatedFormat('d F Y')
                                                : '-' }}
                                        </td>

                                        <td>
                                            {{ optional($pinjams->pengembalian)->denda
                                                ? 'Rp ' . number_format(optional($pinjams->pengembalian)->denda, 0, ',', '.')
                                                : '-' }}
                                        </td>
                                        <td class="text-nowrap">
                                            @php
                                                $pengembalian = $pinjams->pengembalian;
                                            @endphp

                                            @if ($pinjams->status == 'menunggu')
                                                <button class="btn btn-sm btn-warning">Konfirmasi</button>
                                            @elseif ($pinjams->status == 'dipinjam')
                                                <span class="badge bg-primary">Dipinjam</span>
                                            @elseif ($pinjams->status == 'ditolak')
                                                <span class="badge bg-warning text-dark">Ditolak</span>
                                            @elseif ($pinjams->status == 'dikembalikan')
                                                @if ($pengembalian && $pengembalian->status == 'terlambat')
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-success">Dikembalikan</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-center align-middle action-column">
                                            <div class="dropdown dropstart">
                                                <button class="btn border-0 bg-transparent p-0" type="button"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                                </button>

                                                <ul class="dropdown-menu shadow-sm">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2"
                                                            href="#">
                                                            <i class="fas fa-eye"></i>
                                                            <span>Detail</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                                            href="#">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modalKonfirmasi{{ $pinjams->id_peminjaman }}"
                                        tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    Yakin mau konfirmasi peminjaman buku
                                                    <b>{{ $pinjams->buku->judul ?? '-' }}</b> ?
                                                </div>

                                                <div class="modal-footer">

                                                    <!-- TOLAK -->
                                                    <a href="{{ route('peminjaman.tolak', $pinjams->id_peminjaman) }}"
                                                        class="btn btn-danger">
                                                        Tolak
                                                    </a>

                                                    <!-- SETUJUI -->
                                                    <a href="{{ route('peminjaman.acc', $pinjams->id_peminjaman) }}"
                                                        class="btn btn-success">
                                                        Setujui
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                        emptyTable: "📚 buku masih kosong"
                    }
                });
            }
        });
    </script>
@endsection
