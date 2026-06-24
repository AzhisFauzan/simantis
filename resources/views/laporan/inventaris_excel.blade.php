<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris Perangkat IT</title>
    <style>
        /* Pengaturan Kertas A4 Portrait */
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            margin: 0;
            color: #000;
            line-height: 1.4;
        }

        /* --- KOP SURAT --- */
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #16a34a; /* Garis bawah kop hijau Darmayu */
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .kop-surat td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .logo {
            width: 80px;
        }
        .teks-kop {
            text-align: center;
        }
        .teks-kop h1 {
            margin: 0;
            font-size: 18px;
            font-weight: normal;
        }
        .teks-kop h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #16a34a; /* Tulisan DARMAYU warna hijau */
            text-transform: uppercase;
            font-family: 'Cooper Black', 'Georgia', serif; /* Font Darmayu dengan fallback */
        }
        .teks-kop p {
            margin: 5px 0 0 0;
            font-size: 11px;
        }

        /* --- JUDUL LAPORAN --- */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h3 {
            margin: 0;
            font-size: 14px;
            text-decoration: underline;
        }
        .judul-laporan p {
            margin: 2px 0 0 0;
            font-weight: bold;
            font-size: 12px;
        }

        /* --- INFO CETAK --- */
        .info-cetak {
            margin-bottom: 10px;
            font-size: 11px;
        }

        /* --- TABEL DATA --- */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid #16a34a; /* Border tabel warna hijau */
            padding: 6px 5px;
            vertical-align: top;
            word-wrap: break-word;
        }
        .tabel-data th {
            background-color: #16a34a; /* Background header hijau */
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        /* Kombinasi selang-seling hijau muda dan putih untuk baris tabel */
        .tabel-data tr:nth-child(even) { background-color: #f0fdf4; }
        .tabel-data tr:nth-child(odd) { background-color: #ffffff; }

        /* --- TANDA TANGAN --- */
        .tabel-ttd {
            width: 100%;
            margin-top: 30px;
            text-align: center;
            page-break-inside: avoid;
        }
        .tabel-ttd td {
            border: none;
            width: 33.33%;
            padding: 0;
            vertical-align: top;
        }
        .spasi-ttd {
            height: 70px;
        }
    </style>
</head>
<body>

    <table class="kop-surat">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="{{ public_path('logo-darmayu.png') }}" alt="Logo RSU Darmayu" class="logo">
            </td>
            <td width="85%" class="teks-kop">
                <h1>RUMAH SAKIT UMUM</h1>
                <h2>Darmayu</h2>
                <p>Jl. Kapten Tendean No. 47, Kelurahan Demangan Kecamatan Taman Kota Madiun.<br>
                Telp 0351-4109999 | Email: rsudarmayumdn@yahoo.com</p>
            </td>
        </tr>
    </table>

    <div class="judul-laporan">
        <h3>LEMBAR LAPORAN INVENTARIS PERANGKAT IT</h3>
        <p>RSU DARMAYU MADIUN</p>
    </div>

    <div class="info-cetak">
        <p style="margin:0;">Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</p>
        <p style="margin:2px 0 0 0;">Total perangkat: <strong>{{ $perangkat->count() }}</strong></p>
    </div>

    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Kode Inventaris</th>
                <th width="15%">Kategori</th>
                <th width="20%">Ruangan</th>
                <th width="15%">Alamat IP</th>
                <th width="25%">Spesifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perangkat as $i => $p)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $p->kode_inventaris ?? '-' }}</td>
                <td align="center">{{ $p->nama_kategori ?? '-' }}</td>
                <td>{{ $p->nama_ruangan ?? '-' }}</td>
                <td align="center">{{ $p->alamat_ip ?? '-' }}</td>
                <td>{{ $p->spesifikasi ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:20px; color:#555;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="tabel-ttd">
        <tr>
            <td>
                DIREKTUR<br>
                RSU DARMAYU MADIUN
                <div class="spasi-ttd"></div>
                (.................................................)
            </td>
            <td>
                KEPALA BAGIAN<br>
                ADMINISTRASI DAN UMUM
                <div class="spasi-ttd"></div>
                (.................................................)
            </td>
            <td>
                KEPALA UNIT<br>
                IT/PROGRAMMER
                <div class="spasi-ttd"></div>
                (.................................................)
            </td>
        </tr>
    </table>

</body>
</html>
