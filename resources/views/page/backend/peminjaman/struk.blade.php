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
            <td class="label">Nama Anggota</td>
            <td class="value">{{ $anggota->nama_anggota }}</td>
        </tr>
        <tr>
            <td class="label">Petugas</td>
            <td class="value">{{ $petugas }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <!-- DETAIL BUKU (MULTI) -->
    <table>
        @foreach ($data as $item)
            <tr>
                <td class="label">Judul</td>
                <td class="value">{{ $item->buku->judul_buku }}</td>
            </tr>
            <tr>
                <td class="label">Kode</td>
                <td class="value">{{ $item->buku->kode_buku }}</td>
            </tr>
            <tr>
                <td class="label">Pinjam</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}
                </td>
            </tr>
            <tr>
                <td class="label">Kembali</td>
                <td class="value">
                    {{ \Carbon\Carbon::parse($item->pengembalian->tanggal_kembali)->translatedFormat('d F Y') }}
                </td>
            </tr>

            <tr>
                <td class="label">Kondisi & Denda</td>
                <td class="value">
                    @php
                        $kondisi = $item->pengembalian->kondisi_buku ?? null;
                        $denda = $item->pengembalian->denda ?? 0;
                    @endphp

                    @if (!$kondisi)
                        -
                    @else
                        @if ($kondisi == 'baik')
                            Baik
                        @elseif ($kondisi == 'rusak')
                            Rusak
                        @elseif ($kondisi == 'hilang')
                            Hilang
                        @else
                            {{ ucfirst($kondisi) }}
                        @endif

                        @if ($denda > 0)
                            (Rp {{ number_format($denda, 0, ',', '.') }})
                        @endif
                    @endif
                </td>
            </tr>
            </tr>

            <tr>
                <td colspan="2">--------------------------</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <!-- TOTAL DENDA -->
    @php
        $totalDenda = $data->sum(function ($item) {
            return $item->pengembalian->denda ?? 0;
        });
    @endphp

    <table>
        <tr>
            <td class="label"><strong>Total Denda</strong></td>
            <td class="value">
                <strong>
                    @if ($totalDenda == 0)
                        -
                    @else
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    @endif
                </strong>
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
