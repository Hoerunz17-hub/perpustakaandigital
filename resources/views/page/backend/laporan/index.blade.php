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
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama / buku..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="bulan" class="form-control">
                        <option value="">-- Pilih Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="tahun" class="form-control">
                        <option value="">-- Pilih Tahun --</option>
                        @for ($i = date('Y') + 2; $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>



                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                </div>

                <div class="col-md-20 text-end">
                    <a href="{{ route('laporan.cetak', [
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun'),
                        'search' => request('search'),
                    ]) }}"
                        target="_blank" class="btn btn-success">
                        🖨 Cetak PDF
                    </a>
                </div>
            </div>
        </form>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-flex justify-content-between gap-2 flex-wrap">
                        <div>
                            Table Laporan
                        </div>
                        <a href="{{ route('laporan.cetak', [
                            'bulan' => request('bulan'),
                            'tahun' => request('tahun'),
                            'search' => request('search'),
                        ]) }}"
                            target="_blank" class="btn btn-primary">
                            <iconify-icon icon="mdi:printer" width="20" height="20"></iconify-icon>
                        </a>

                    </h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table fw-bold" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">No</th>
                                    <th class="text-nowrap">Nama</th>
                                    <th class="text-nowrap">Buku Dipinjam</th>
                                    <th class="text-nowrap">Tanggal Pinjam</th>
                                    <th class="text-nowrap">Wajib Kembali</th>
                                    <th class="text-nowrap">Tanggal Kembali</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                                        <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                                        {{-- Tanggal Pinjam --}}
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d F Y') }}
                                        </td>
                                        {{-- Wajib Kembali --}}
                                        <td>
                                            {{ $item->wajib_kembali ? \Carbon\Carbon::parse($item->wajib_kembali)->format('d F Y') : '-' }}
                                        </td>
                                        {{-- Tanggal Kembali --}}
                                        <td>
                                            {{ $item->pengembalian && $item->pengembalian->tanggal_kembali
                                                ? \Carbon\Carbon::parse($item->pengembalian->tanggal_kembali)->format('d F Y')
                                                : '-' }}
                                        </td>

                                        <td>
                                            @php
                                                $status = $item->status_final;
                                            @endphp

                                            @if ($status == 'dipinjam')
                                                <span class="badge bg-light-primary">Dipinjam</span>
                                            @elseif($status == 'menunggu')
                                                <span class="badge bg-light-warning">Menunggu</span>
                                            @elseif($status == 'terlambat')
                                                <span class="badge bg-light-danger">Terlambat</span>
                                            @elseif($status == 'dikembalikan')
                                                <span class="badge bg-light-success">Dikembalikan</span>
                                            @elseif($status == 'ditolak')
                                                <span class="badge bg-light-secondary">Ditolak</span>
                                            @else
                                                <span class="badge bg-dark">{{ ucfirst($status) }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            Rp {{ number_format(optional($item->pengembalian)->denda ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        emptyTable: "Tidak Ada Laporan"
                    }
                });
            }
        });
    </script>
@endsection
