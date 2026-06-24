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
            margin-bottom: 5px; /* Jarak ke garis bawah */
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .td-logo {
            width: 20%;
            text-align: center;
            /* Garis putus-putus dihilangkan sesuai gambar */
        }
        .td-teks {
            width: 80%;
            text-align: center;
        }
        .logo {
            width: 100px; /* Sesuaikan dengan kebutuhan aslinya */
        }

        /* Tipografi Kop Surat */
        .kop-rsu {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 0px;
            text-transform: uppercase;
        }
        .kop-darmayu {
            margin: -2px 0;
            font-family: 'Cooper Black', 'Georgia', serif;
            font-size: 38px;
            font-weight: bold;
            color: #16a34a; /* Hijau Darmayu */
        }
        .kop-madiun {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 6px;
            text-transform: uppercase;
        }
        .kop-alamat {
            margin: 0;
            font-size: 12px;
        }
        .link-email {
            color: #2563eb; /* Warna biru untuk alamat email */
            text-decoration: underline;
        }

        /* Garis Bawah Kop Surat Ganda (Resmi) */
        .garis-kop {
            border-top: 3px solid #000;   /* Garis atas tebal */
            border-bottom: 1px solid #000; /* Garis bawah tipis */
            height: 2px;                  /* Jarak antar garis */
            width: 100%;
            margin-bottom: 20px;
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
            border: 1px solid #16a34a;
            padding: 6px 5px;
            vertical-align: top;
            word-wrap: break-word;
        }
        .tabel-data th {
            background-color: #16a34a;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
        }

        /* Kombinasi selang-seling hijau muda dan putih untuk baris tabel */
        .tabel-data tr:nth-child(even) { background-color: #f0fdf4; }
        .tabel-data tr:nth-child(odd) { background-color: #ffffff; }

        /* Pengaturan Lebar Kolom */
        .col-no { width: 30px; text-align: center; }
        .col-kode { width: 110px; }
        .col-kat { width: 80px; text-align: center; }
        .col-ruang { width: 110px; }
        .col-ip { width: 90px; text-align: center; }
        .col-spek { width: auto; }

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
            <td class="td-logo">
                <img src="{{ public_path('logo-darmayu.png') }}" alt="Logo RSU Darmayu" class="logo">
            </td>
            <td class="td-teks">
                <div class="kop-rsu">RUMAH SAKIT UMUM</div>
                <div class="kop-darmayu">Darmayu</div>
                <div class="kop-madiun">MADIUN</div>
                <p class="kop-alamat">
                    Jl. Kapten Tendean No. 47, Kelurahan Demangan Kecamatan Taman Kota Madiun.<br>
                    Telp 0351 &ndash; 4109999 | Email : <span class="link-email">rsudarmayumdn@yahoo.com</span>
                </p>
            </td>
        </tr>
    </table>
    <div class="garis-kop"></div>

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
                <th class="col-no">NO</th>
                <th class="col-kode">KODE INVENTARIS</th>
                <th class="col-kat">KATEGORI</th>
                <th class="col-ruang">RUANGAN</th>
                <th class="col-ip">ALAMAT IP</th>
                <th class="col-spek">SPESIFIKASI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perangkat as $i => $p)
            <tr>
                <td class="col-no">{{ $i + 1 }}</td>
                <td>{{ $p->kode_inventaris ?? '-' }}</td>
                <td class="col-kat">{{ $p->nama_kategori ?? '-' }}</td>
                <td>{{ $p->nama_ruangan ?? '-' }}</td>
                <td class="col-ip">{{ $p->alamat_ip ?? '-' }}</td>
                <td>{{ $p->spesifikasi ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; background-color: #ffffff; color: #555;">
                    Data perangkat tidak tersedia.
                </td>
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
