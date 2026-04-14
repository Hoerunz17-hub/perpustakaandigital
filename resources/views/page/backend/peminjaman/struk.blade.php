<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            line-height: 1.5;
        }

        .text-center {
            text-align: center;
        }

        .header {
            margin-bottom: 5px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 11px;
        }

        .line {
            border-top: 1px dashed black;
            margin: 6px 0;
        }

        table {
            width: 100%;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
        }

        td.label {
            width: 47%;
        }

        td.value {
            width: 55%;
            text-align: right;
        }

        .status {
            font-weight: bold;
        }

        .terlambat {
            color: rgb(0, 0, 0);
        }

        .normal {
            color: black;
        }

        .footer {
            margin-top: 8px;
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="text-center header">
        <div class="title">RakBuku</div>
        <div class="subtitle">Struk Pengembalian Buku</div>
    </div>

    <div class="line"></div>

    <!-- INFO UTAMA -->
    <table>
        <tr>
            <td class="label">No Peminjaman</td>
            <td class="value">#{{ $data->id_peminjaman }}</td>
        </tr>
        <tr>
            <td class="label">Nama Anggota</td>
            <td class="value">{{ $data->anggota->nama_anggota }}</td>
        </tr>
        <tr>
            <td class="label">Petugas</td>
            <td class="value"> {{ $data->petugas->nama_petugas ?? '-' }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- DETAIL BUKU -->
    <table>
        <tr>
            <td class="label">Judul Buku</td>
            <td class="value">{{ $data->buku->judul_buku }}</td>
        </tr>
        <tr>
            <td class="label">Kode Buku</td>
            <td class="value">{{ $data->buku->kode_buku }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pinjam</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($data->tanggal_pinjam)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Wajib Kembali</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($data->wajib_kembali)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Tanggal Kembali</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($data->pengembalian->tanggal_kembali)->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- DENDA -->
    <table>
        <tr>
            <td class="label">Denda</td>
            <td class="value">
                @if (!$data->pengembalian || $data->pengembalian->denda == 0)
                    -
                @else
                    Rp {{ number_format($data->pengembalian->denda, 0, ',', '.') }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td
                class="value status
                @if ($data->pengembalian && $data->pengembalian->status == 'terlambat') terlambat
                @else
                    normal @endif
            ">
                @if ($data->pengembalian && $data->pengembalian->status == 'terlambat')
                    TERLAMBAT
                @else
                    DIKEMBALIKAN
                @endif
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- FOOTER -->
    <div class="footer">
        Terima kasih telah menggunakan layanan perpustakaan RakBuku <br><br>
        Dicetak: {{ now()->translatedFormat('d F Y H:i') }} <br>
    </div>

</body>

</html>
