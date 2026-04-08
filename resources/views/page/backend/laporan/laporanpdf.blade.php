<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
        }

        .info {
            margin-bottom: 10px;
        }

        .info table {
            width: 100%;
            border: none;
        }

        .info td {
            border: none;
            padding: 2px;
            font-size: 12px;
        }

        .summary {
            margin-bottom: 15px;
            border: 1px solid #000;
            padding: 10px;
        }

        .summary table {
            width: 100%;
            border: none;
        }

        .summary td {
            border: none;
            padding: 4px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            text-align: center;
        }

        table.data th {
            background: #eee;
        }

        table.data td:nth-child(2),
        table.data td:nth-child(3) {
            text-align: left;
        }

        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd td {
            border: none;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- ✅ IDENTITAS -->
    <div class="header">
        <h2>PERPUSTAKAAN DIGITAL</h2>
        <p>SMK NEGERI 1 (ISI SENDIRI)</p>
        <p>Jl. Contoh Alamat No.123</p>
        <hr>
        <h3>LAPORAN PEMINJAMAN BUKU</h3>
    </div>

    <!-- ✅ INFO -->
    <div class="info">
        <table>
            <tr>
                <td>Periode</td>
                <td>:
                    @if ($bulan && $tahun)
                        {{ \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F') }} {{ $tahun }}
                    @else
                        Semua Periode
                    @endif
                </td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ \Carbon\Carbon::now()->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Petugas</td>
                <td>: Kepala Perpustakaan</td>
            </tr>
        </table>
    </div>

    @php
        $totalPeminjaman = count($data);

        $totalDenda = 0;
        $totalTerlambat = 0;
        $totalDipinjam = 0;

        foreach ($data as $item) {
            if ($item->pengembalian) {
                $totalDenda += $item->pengembalian->denda;
            }

            if (($item->status_final ?? $item->status) == 'terlambat') {
                $totalTerlambat++;
            }

            if (($item->status_final ?? $item->status) == 'dipinjam') {
                $totalDipinjam++;
            }
        }
    @endphp

    <!-- ✅ SUMMARY -->
    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Peminjaman</strong></td>
                <td>: {{ $totalPeminjaman }}</td>

                <td><strong>Total Terlambat</strong></td>
                <td>: {{ $totalTerlambat }}</td>
            </tr>
            <tr>
                <td><strong>Masih Dipinjam</strong></td>
                <td>: {{ $totalDipinjam }}</td>

                <td><strong>Total Denda</strong></td>
                <td>: Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- ✅ TABEL -->
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Wajib Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->anggota->nama_anggota }}</td>
                    <td>{{ $item->buku->judul_buku }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $item->wajib_kembali ? \Carbon\Carbon::parse($item->wajib_kembali)->format('d-m-Y') : '-' }}
                    </td>

                    <td>
                        {{ $item->pengembalian && $item->pengembalian->tanggal_kembali
                            ? \Carbon\Carbon::parse($item->pengembalian->tanggal_kembali)->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>{{ ucfirst($item->status_final ?? $item->status) }}</td>

                    <td>
                        Rp {{ number_format(optional($item->pengembalian)->denda ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



</body>

</html>
