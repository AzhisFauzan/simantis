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
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            color: #1e293b;
            line-height: 1.4;
        }

        /* --- KOP SURAT --- */
        .kop-rsu { margin: 0; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; color: #0f172a; text-transform: uppercase; }
        .kop-surat { width: 100%; margin-bottom: 8px; border-collapse: collapse; }
        .kop-surat td { vertical-align: middle; border: none; padding: 0; }
        .td-logo { width: 18%; text-align: center; }
        .td-teks { width: 82%; text-align: center; }
        .logo { width: 90px; }

        .kop-darmayu { margin: -2px 0 2px 0; font-family: 'Georgia', serif; font-size: 32px; font-weight: bold; color: #16a34a; }
        .kop-madiun { margin: 0 0 6px 0; font-size: 10px; font-weight: bold; letter-spacing: 5px; color: #475569; text-transform: uppercase; }
        .kop-alamat { margin: 0; font-size: 10px; color: #334155; }
        .link-email { color: #2563eb; text-decoration: none; }

        .garis-kop { border-top: 2.5px solid #0f172a; border-bottom: 1px solid #0f172a; height: 2px; width: 100%; margin-bottom: 24px; }

        /* --- JUDUL LAPORAN --- */
        .judul-laporan { text-align: center; margin-bottom: 20px; }
        .judul-laporan h3 { margin: 0; font-size: 12px; font-weight: 800; text-decoration: underline; color: #0f172a; }
        .judul-laporan p { margin: 4px 0 0 0; font-weight: 600; font-size: 10px; color: #475569; }

        /* --- INFO CETAK & RINGKASAN --- */
        .info-cetak { margin-bottom: 15px; font-size: 10px; width: 100%; border-collapse: collapse; color: #334155; }
        .info-cetak td { border: none; padding: 3px 0; }

        /* --- TABEL DATA --- */
        .tabel-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .tabel-data th, .tabel-data td { border: 1px solid #cbd5e1; padding: 8px 6px; vertical-align: middle; word-wrap: break-word; }
        .tabel-data th { background-color: #16a34a; color: #ffffff; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 9px; letter-spacing: 0.5px; }
        .tabel-data tr:nth-child(even) { background-color: #f8fafc; }
        .tabel-data tr:nth-child(odd) { background-color: #ffffff; }

        /* --- TANDA TANGAN --- */
        .tabel-ttd { width: 100%; margin-top: 40px; text-align: center; page-break-inside: avoid; }
        .tabel-ttd td { border: none; width: 33.33%; padding: 0; vertical-align: top; font-size: 10px; color: #1e293b; }
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