<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Maintenance IT</title>
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
        .kop-rsu { margin: 0; font-size: 22px; font-weight: bold; letter-spacing: 0px; text-transform: uppercase; }
        .kop-surat { width: 100%; margin-bottom: 5px; border-collapse: collapse; }
        .kop-surat td { vertical-align: middle; border: none; padding: 0; }
        .td-logo { width: 20%; text-align: center; }
        .td-teks { width: 80%; text-align: center; }
        .logo { width: 100px; }

        .kop-darmayu { margin: 0; font-family: 'Cooper Black', 'Georgia', serif; font-size: 38px; font-weight: bold; color: #16a34a; }
        .kop-madiun { margin: 0 0 5px 0; font-size: 14px; font-weight: bold; letter-spacing: 6px; text-transform: uppercase; }
        .kop-alamat { margin: 0; font-size: 12px; }
        .link-email { color: #2563eb; text-decoration: none; }

        .garis-kop { border-top: 3px solid #000; border-bottom: 1px solid #000; height: 2px; width: 100%; margin-bottom: 20px; }

        /* --- JUDUL LAPORAN --- */
        .judul-laporan { text-align: center; margin-bottom: 20px; }
        .judul-laporan h3 { margin: 0; font-size: 14px; text-decoration: underline; }
        .judul-laporan p { margin: 2px 0 0 0; font-weight: bold; font-size: 12px; }

        /* --- INFO CETAK & RINGKASAN --- */
        .info-cetak { margin-bottom: 15px; font-size: 11px; width: 100%; border-collapse: collapse; }
        .info-cetak td { border: none; padding: 3px 0; }

        /* --- TABEL DATA --- */
        .tabel-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .tabel-data th, .tabel-data td { border: 1px solid #16a34a; padding: 6px 5px; vertical-align: top; word-wrap: break-word; }
        .tabel-data th { background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 10px; }
        .tabel-data tr:nth-child(even) { background-color: #f0fdf4; }
        .tabel-data tr:nth-child(odd) { background-color: #ffffff; }

        /* --- TANDA TANGAN --- */
        .tabel-ttd { width: 100%; margin-top: 30px; text-align: center; page-break-inside: avoid; }
        .tabel-ttd td { border: none; width: 33.33%; padding: 0; vertical-align: top; }
        .spasi-ttd { height: 70px; }
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
        <h3>LEMBAR LAPORAN RIWAYAT MAINTENANCE IT</h3>
        <p>RSU DARMAYU MADIUN</p>
    </div>

    <table class="info-cetak">
        <tr>
            <td width="50%"><strong>Dicetak pada:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</td>
            <td width="50%" align="right"><strong>Total Data:</strong> {{ $maintenances->count() }} Data</td>
        </tr>
        <tr>
            <td><strong>Teknisi Terlibat:</strong> {{ $maintenances->unique('nama_teknisi')->count() }} Orang</td>
            <td align="right"><strong>Total Ruangan:</strong> {{ $maintenances->unique('nama_ruangan')->count() }} Ruangan</td>
        </tr>
    </table>

    <table class="tabel-data">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="12%">KODE INVENTARIS</th>
                <th width="18%">KATEGORI</th>
                <th width="15%">RUANGAN</th>
                <th width="12%">TEKNISI</th>
                <th width="13%">TANGGAL</th>
                <th width="25%">DESKRIPSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $i => $m)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td align="center">{{ $m->kode_inventaris ?? '-' }}</td>
                <td>
                    <div style="margin-bottom: 5px;"><strong>{{ $m->kategori ?? '-' }}</strong></div>
                    {{-- <div>{!! $m->sumber_html !!}</div> --}}
                </td>
                <td>{{ $m->nama_ruangan ?? '-' }}</td>
                <td>{{ $m->nama_teknisi ?? '-' }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($m->tanggal)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                <td>{!! $m->deskripsi ?? '-' !!}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px; color: #555;">Tidak ada data riwayat maintenance.</td>
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