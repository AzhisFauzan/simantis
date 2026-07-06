@extends('layout.page')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        /* Warna Khas RS Darmayu */
        --rs-purple:       #6b21a8; /* Ungu Utama */
        --rs-purple-hover: #581c87;
        --rs-purple-soft:  #f3e8ff;
        --rs-purple-mid:   #d8b4fe;

        --rs-green:        #16a34a; /* Hijau Utama */
        --rs-green-hover:  #15803d;
        --rs-green-soft:   #dcfce7;

        --slate:     #f8fafc;
        --border:    #e2e8f0;
        --text-main: #0f172a;
        --text-sub:  #64748b;
        --radius:    10px;
    }

    * { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 4px 0;
    }
    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.3px;
        margin: 0;
    }

    /* ── Filter Card ── */
    .filter-wrapper {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 1px 8px rgba(0,0,0,.02);
    }
    .filter-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--rs-purple);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 13.5px;
        color: var(--text-main);
        font-weight: 500;
        margin-bottom: 12px;
    }
    .checkbox-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--rs-purple);
    }

    /* ── Buttons ── */
    .btn-rs-purple {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--rs-purple);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-rs-purple:hover { background: var(--rs-purple-hover); color: #fff; }

    .btn-rs-green {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-rs-green:hover { background: var(--rs-green-hover); color: #fff; }

    .btn-rs-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: #ef4444;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-rs-danger:hover { background: #dc2626; color: #fff; }

    .btn-rs-slate {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--slate);
        color: var(--text-sub);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s;
        text-decoration: none;
    }
    .btn-rs-slate:hover { background: #e2e8f0; color: var(--text-main); text-decoration: none; }

    /* ── Room Cards ── */
    .room-stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: box-shadow 0.15s, border-color 0.15s;
    }
    .room-stat-card:hover {
        border-color: var(--rs-purple-mid);
        box-shadow: 0 4px 12px rgba(107,33,168,.06);
    }
    .icon-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--rs-purple-soft);
        color: var(--rs-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .room-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 2px 0;
    }
    .room-subtitle {
        font-size: 12px;
        color: var(--text-sub);
        font-weight: 500;
    }
    .print-status {
        font-size: 11.5px;
        padding-top: 12px;
        margin-top: 12px;
        margin-bottom: 14px;
        border-top: 1px dashed var(--border);
        font-weight: 500;
    }
    .print-status.success { color: var(--rs-green-hover); }
    .print-status.muted { color: var(--text-sub); }

    /* ── Detail Table ── */
    .detail-table-wrapper {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 16px rgba(0,0,0,.04);
    }
    .detail-table-header {
        background: var(--rs-purple);
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail-table-title {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-close-table {
        background: rgba(255,255,255,.2);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-close-table:hover { background: rgba(255,255,255,.3); }

    .custom-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .custom-table thead th {
        background: var(--slate);
        color: var(--text-sub);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border);
        font-size: 11px;
    }
    .custom-table tbody tr { border-bottom: 1px solid var(--slate); transition: background .15s; }
    .custom-table tbody tr:hover { background: var(--rs-purple-soft); }
    .custom-table td { padding: 12px 16px; color: var(--text-main); vertical-align: middle; }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        background: #fff;
        border: 1px dashed var(--border);
        border-radius: 12px;
    }
    .empty-icon {
        width: 56px; height: 56px;
        background: var(--slate);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        color: #cbd5e1;
    }

    /* Loading state */
    .loading-overlay {
        display: none;
        text-align: center;
        padding: 20px;
    }
    .loading-overlay.show { display: block; }
</style>

<div class="container-fluid px-0">
    <div class="page-header">
        <h1 class="page-title">
            Laporan Inventaris IT
        </h1>
    </div>

    <div id="loading" class="loading-overlay">
        <div class="spinner-border" style="color: var(--rs-purple);" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="mt-2 mb-0" style="color: var(--text-sub); font-weight:500; font-size:13px;">Memuat data, mohon tunggu...</p>
    </div>

    {{-- Filter Wrapper --}}
    <div class="filter-wrapper">
        <div class="filter-title">
            <i class="fas fa-filter"></i> Filter Laporan
        </div>
        <form method="GET" action="{{ url('/laporan/inventaris') }}">
            <div class="mb-3">
                <label style="font-size:12px; font-weight:600; color:var(--text-main); display:block; margin-bottom:12px;">
                    Pilih Ruangan <span style="font-weight:400; color:var(--text-sub); text-transform:none;">(centang ruangan yang ingin dilaporkan)</span>
                </label>

                <label class="checkbox-item mb-3 pb-3" style="border-bottom: 1px solid var(--border);">
                    <input type="checkbox" id="checkAll">
                    <span style="color: var(--rs-purple); font-weight: 700;">Pilih Semua Ruangan</span>
                </label>

                <div class="row">
                    @foreach($ruangan as $ruang)
                    <div class="col-md-3 col-sm-4 col-6">
                        <label class="checkbox-item" for="ruang_{{ $ruang->id_ruangan }}">
                            <input type="checkbox"
                                class="ruangan-check"
                                name="id_ruangan[]"
                                value="{{ $ruang->id_ruangan }}"
                                id="ruang_{{ $ruang->id_ruangan }}"
                                {{ in_array($ruang->id_ruangan, (array) request('id_ruangan', [])) ? 'checked' : '' }}>
                            <span>{{ $ruang->nama_ruangan }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-4" style="display:flex; gap:8px;">
                <button type="submit" class="btn-rs-purple">
                    <i class="fas fa-search"></i> Tampilkan Laporan
                </button>
                <a href="{{ url('/laporan/inventaris') }}" class="btn-rs-slate">
                    <i class="fas fa-undo"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>

    {{-- Tampilan Hasil Laporan --}}
    @if(request()->has('id_ruangan') && count((array) request('id_ruangan')) > 0)

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:12px;">
            <h6 style="font-size:14px; font-weight:700; color:var(--text-main); margin:0;">
                Menampilkan data untuk {{ count((array) request('id_ruangan')) }} ruangan
            </h6>
            <div style="display:flex; gap:8px;">
                <button onclick="bukaLaporan('{{ route('laporan.inventaris.print') }}')" class="btn-rs-danger">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </button>
            </div>
        </div>

        <div class="row">
            @foreach($ruangan as $ruang)
                @if(in_array($ruang->id_ruangan, (array) request('id_ruangan', [])))

                    @php
                        $terakhirCetak = $perangkat->firstWhere('id_ruangan', $ruang->id_ruangan)?->terakhir_cetak ?? null;
                        $jumlahPerangkat = $perangkat->where('id_ruangan', $ruang->id_ruangan)->count();
                    @endphp

                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="room-stat-card">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle mr-3">
                                    <i class="fas fa-door-open"></i>
                                </div>
                                <div>
                                    <h6 class="room-title">{{ $ruang->nama_ruangan }}</h6>
                                    <div class="room-subtitle">{{ $jumlahPerangkat }} perangkat terdaftar</div>
                                </div>
                            </div>

                            <div class="print-status {{ $terakhirCetak ? 'success' : 'muted' }}">
                                @if($terakhirCetak)
                                    <i class="fas fa-print mr-1"></i> Terakhir cetak:
                                    <strong>{{ \Carbon\Carbon::parse($terakhirCetak)->tz('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY, HH:mm') }} WIB</strong>
                                @else
                                    <i class="fas fa-clock mr-1"></i> Belum pernah dicetak
                                @endif
                            </div>

                            <button class="btn-rs-purple" style="width: 100%; margin-top: auto;"
                                    id="btn_{{ $ruang->id_ruangan }}"
                                    onclick="lihatDetail({{ $ruang->id_ruangan }})">
                                <i class="fas fa-table"></i> Lihat Data Perangkat
                            </button>
                        </div>
                    </div>

                    <div class="col-12 mb-4 tabel-detail" id="tabel_{{ $ruang->id_ruangan }}" style="display:none;">
                        <div class="detail-table-wrapper">
                            <div class="detail-table-header">
                                <h6 class="detail-table-title">
                                    <i class="fas fa-desktop"></i> Perangkat di {{ $ruang->nama_ruangan }}
                                </h6>
                                <button class="btn-close-table" onclick="tutupDetail({{ $ruang->id_ruangan }})">
                                    <i class="fas fa-times mr-1"></i> Tutup
                                </button>
                            </div>
                            <div style="overflow-x: auto;">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px; text-align: center;">No</th>
                                            <th>Kode Inventaris</th>
                                            <th>Kategori</th>
                                            <th>Alamat IP</th>
                                            <th>Spesifikasi</th>
                                            <th>Terakhir Cetak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach($perangkat as $p)
                                            @if($p->id_ruangan == $ruang->id_ruangan)
                                            <tr>
                                                <td style="text-align: center;">{{ $no++ }}</td>
                                                <td><span style="background:var(--slate); border:1px solid var(--border); padding:3px 8px; border-radius:6px; font-weight:600; font-size:12px;">{{ $p->kode_inventaris ?? '-' }}</span></td>
                                                <td style="font-weight:500;">{{ $p->nama_kategori ?? '-' }}</td>
                                                <td style="font-family:monospace; color:var(--text-sub);">{{ $p->alamat_ip ?? '-' }}</td>
                                                <td>{{ $p->spesifikasi ?? '-' }}</td>
                                                <td>
                                                    @if($p->terakhir_cetak)
                                                        <span style="color:var(--rs-green-hover); font-size:12px; font-weight:600;">
                                                            <i class="fas fa-check-circle mr-1"></i>{{ \Carbon\Carbon::parse($p->terakhir_cetak)->tz('Asia/Jakarta')->locale('id')->isoFormat('D MMM, HH:mm') }}
                                                        </span>
                                                    @else
                                                        <span style="color:var(--text-sub); font-size:12px;">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-hand-pointer"></i>
            </div>
            <h5 style="font-size:16px; font-weight:700; color:var(--text-main); margin-bottom:8px;">Pilih ruangan terlebih dahulu</h5>
            <p style="font-size:13px; margin:0;">Centang ruangan yang ingin ditampilkan pada panel di atas, lalu klik <strong>Tampilkan Laporan</strong></p>
        </div>
    @endif
</div>

<script>
    // Logika Check All
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.ruangan-check').forEach(cb => cb.checked = this.checked);
    });

    // Toggle lihat/tutup tabel detail
    function lihatDetail(idRuangan) {
        const tabel  = document.getElementById('tabel_' + idRuangan);
        const tombol = document.getElementById('btn_' + idRuangan);

        if (tabel.style.display === 'none' || tabel.style.display === '') {
            tabel.style.display = 'block';
            tombol.innerHTML     = '<i class="fas fa-eye-slash"></i> Tutup Data';
            tombol.classList.replace('btn-rs-purple', 'btn-rs-slate');
            tabel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            tabel.style.display = 'none';
            tombol.innerHTML     = '<i class="fas fa-table"></i> Lihat Data Perangkat';
            tombol.classList.replace('btn-rs-slate', 'btn-rs-purple');
        }
    }

    function tutupDetail(idRuangan) {
        const tabel  = document.getElementById('tabel_' + idRuangan);
        const tombol = document.getElementById('btn_' + idRuangan);

        tabel.style.display = 'none';
        tombol.innerHTML     = '<i class="fas fa-table"></i> Lihat Data Perangkat';
        tombol.classList.replace('btn-rs-slate', 'btn-rs-purple');
    }

    // Logika Cetak Laporan
    function bukaLaporan(baseUrl) {
        const checked = document.querySelectorAll('.ruangan-check:checked');
        if (checked.length === 0) {
            alert('Pilih minimal 1 ruangan pada kotak filter terlebih dahulu.');
            return;
        }
        const params = Array.from(checked)
            .map(cb => 'id_ruangan[]=' + cb.value)
            .join('&');
        window.open(baseUrl + '?' + params, '_blank');
    }
</script>
@endsection
