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
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            color: #1e293b;
            line-height: 1.4;
        }

        /* --- KOP SURAT --- */
        .kop-surat {
            width: 100%;
            margin-bottom: 8px;
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .td-logo {
            width: 18%;
            text-align: center;
        }
        .td-teks {
            width: 82%;
            text-align: center;
        }
        .logo {
            width: 90px;
        }

        /* Tipografi Kop Surat */
        .kop-rsu {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .kop-darmayu {
            margin: -2px 0 2px 0;
            font-family: 'Georgia', serif;
            font-size: 32px;
            font-weight: bold;
            color: #16a34a;
        }
        .kop-madiun {
            margin: 0 0 6px 0;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #475569;
        }
        .kop-alamat {
            margin: 0;
            font-size: 10px;
            color: #334155;
        }
        .link-email {
            color: #2563eb;
            text-decoration: none;
        }

        /* Garis Bawah Kop Surat Ganda (Resmi) */
        .garis-kop {
            border-top: 2.5px solid #0f172a;
            border-bottom: 1px solid #0f172a;
            height: 2px;
            width: 100%;
            margin-bottom: 24px;
        }

        /* --- JUDUL LAPORAN --- */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h3 {
            margin: 0;
            font-size: 12px;
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }
        .judul-laporan p {
            margin: 4px 0 0 0;
            font-weight: 600;
            font-size: 10px;
            color: #475569;
        }

        /* --- INFO CETAK --- */
        .info-cetak {
            margin-bottom: 12px;
            font-size: 10px;
            color: #334155;
        }

        /* --- TABEL DATA --- */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid #cbd5e1;
            padding: 8px 6px;
            vertical-align: middle;
            word-wrap: break-word;
        }
        .tabel-data th {
            background-color: #16a34a;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tabel-data tr:nth-child(even) { background-color: #f8fafc; }
        .tabel-data tr:nth-child(odd) { background-color: #ffffff; }

        /* Pengaturan Lebar Kolom */
        .col-no { width: 30px; text-align: center; }
        .col-kode { width: 100px; text-align: center; font-weight: 600; }
        .col-kat { width: 80px; text-align: center; }
        .col-ruang { width: 110px; }
        .col-ip { width: 90px; text-align: center; font-family: monospace; font-size: 11px; }
        .col-spek { width: auto; color: #475569; }

        /* --- TANDA TANGAN --- */
        .tabel-ttd {
            width: 100%;
            margin-top: 40px;
            text-align: center;
            page-break-inside: avoid;
        }
        .tabel-ttd td {
            border: none;
            width: 33.33%;
            padding: 0;
            vertical-align: top;
            font-size: 10px;
            color: #1e293b;
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
