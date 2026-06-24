@extends('layout.page')
@section("judul","Jadwal Maintenance")
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
        --border:    #cbd5e1;
        --text-main: #0f172a;
        --text-sub:  #475569;
    }

    * { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.3px;
        margin: 0;
    }
    .page-subtitle {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-sub);
        margin-top: 3px;
    }
    .btn-row {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    /* ── Buttons ── */
    .btn-solid {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
        box-shadow: 0 2px 6px rgba(22, 163, 74, 0.2);
    }
    .btn-solid:hover { background: var(--rs-green-hover); color: #fff; text-decoration: none; }

    /* Fix tombol riwayat agar tidak ada garis bawah */
    .btn-outline-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: var(--text-main);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important; /* Menghilangkan garis bawah */
        transition: all .15s;
    }
    .btn-outline-sm:hover {
        background: var(--slate);
        color: var(--rs-purple);
        border-color: var(--rs-purple-mid);
        text-decoration: none !important;
    }

    .btn-danger-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: #dc2626;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important;
        transition: background .15s;
    }
    .btn-danger-sm:hover { background: #fef2f2; text-decoration: none !important; }

    .sel-badge {
        background: #fef2f2;
        color: #dc2626;
        border-radius: 20px;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid #fecaca;
    }

    /* ── Filter Tanggal Toolbar ── */
    .toolbar-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 14px;
    }
    .toolbar-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .toolbar-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }
    .date-input {
        padding: 6px 10px;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-main);
        background: var(--slate);
        outline: none;
        font-family: 'DM Sans', sans-serif;
        transition: border-color .15s;
    }
    .date-input:focus { border-color: var(--rs-purple); background: #fff; }
    .date-sep { font-size: 12px; font-weight: 600; color: var(--text-sub); }
    .divider-v { width: 1px; height: 24px; background: var(--border); }

    .quick-pills { display: flex; gap: 6px; flex-wrap: wrap; }
    .quick-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-sub);
        cursor: pointer;
        transition: all .15s;
    }
    .quick-pill:hover { background: var(--rs-purple-soft); color: var(--rs-purple); border-color: var(--rs-purple-mid); }
    .quick-pill.active { background: var(--rs-purple); color: #fff; border-color: var(--rs-purple); }

    .btn-reset {
        margin-left: auto;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid var(--border);
        border-radius: 6px;
        background: transparent;
        color: var(--text-main);
        cursor: pointer;
        transition: background .15s;
    }
    .btn-reset:hover { background: var(--slate); }

    /* ── Filter Kategori Dropdown ── */
    .filter-dropdown-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .select-kategori {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-main);
        background: #fff;
        outline: none;
        font-family: 'DM Sans', sans-serif;
        min-width: 220px;
        cursor: pointer;
    }
    .select-kategori:focus { border-color: var(--rs-purple); }

    /* ── Result Info ── */
    .result-info {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-sub);
        margin-bottom: 12px;
    }

    /* ── Maintenance Cards ── */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 80px;
    }
    @media (max-width: 900px) { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 580px) { .cards-grid { grid-template-columns: 1fr; } }

    .maintenance-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: border-color .15s, box-shadow .15s;
        cursor: pointer;
    }
    .maintenance-card:hover { border-color: var(--rs-purple-mid); box-shadow: 0 4px 10px rgba(107, 33, 168, 0.05); }
    .maintenance-card.selected { border-color: var(--rs-purple); background-color: #faf5ff; box-shadow: 0 0 0 2px rgba(107, 33, 168, 0.15); }

    .card-checkbox { position: absolute; top: 14px; right: 14px; width: 16px; height: 16px; cursor: pointer; accent-color: var(--rs-purple); z-index: 10; }

    .mcard-room { font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; padding-right: 24px; }
    .mcard-date-badge { display: inline-flex; align-items: center; gap: 4px; background: var(--rs-purple-soft); color: var(--rs-purple); border-radius: 4px; padding: 3px 8px; font-size: 11px; font-weight: 700; margin-bottom: 10px; border: 1px solid var(--rs-purple-mid); }
    .mcard-meta { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: var(--text-main); margin-bottom: 8px; }
    .mcard-desc { font-size: 12px; color: var(--text-sub); font-weight: 500; line-height: 1.5; margin-bottom: 14px; flex: 1; }
    .btn-detail-card { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 6px; background: var(--slate); font-size: 12px; font-weight: 700; color: var(--text-main); cursor: pointer; transition: all .15s; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-detail-card:hover { background: var(--rs-purple-soft); color: var(--rs-purple); border-color: var(--rs-purple); }

    .empty-state { text-align: center; padding: 40px 20px; color: var(--text-sub); font-size: 13px; font-weight: 600; display: none; grid-column: 1 / -1; }

    /* ── Modals ── */
    .modal-content { border-radius: 12px; border: 1px solid var(--border); overflow: hidden; }
    .modal-body    { padding: 20px 24px; }
    .modal-footer  { border-top: 1px solid var(--slate); padding: 14px 24px; background: #fff; }

    .mhead { display: flex; justify-content: space-between; align-items: center; padding: 16px 24px 14px; border-bottom: 1px solid var(--slate); }
    .mhead.purple { background: var(--rs-purple); border-bottom: none; }
    .mhead .modal-title { font-size: 15px; font-weight: 700; margin: 0; }
    .mhead.purple .modal-title, .mhead.purple .close { color: #fff; }
    .mhead.purple .close { opacity: .85; text-shadow: none; font-size: 20px; }
    .mhead.purple .close:hover { opacity: 1; }

    .btn-tutup-detail { padding: 8px 20px; font-size: 12px; font-weight: 700; border: none; border-radius: 6px; background: #475569; color: #fff; cursor: pointer; transition: background .15s; }
    .btn-tutup-detail:hover { background: #334155; }

    .detail-list { display: flex; flex-direction: column; gap: 10px; }
    .detail-item { padding: 12px 14px; background: var(--slate); border-radius: 8px; border: 1px solid var(--border); }
    .detail-label { font-size: 10px; font-weight: 700; color: var(--text-sub); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px; }
    .detail-value { font-size: 13px; font-weight: 700; color: var(--text-main); }
    .detail-value-desc { font-size: 12px; font-weight: 500; color: var(--text-main); line-height: 1.5; margin-top: 6px; background: #fff; padding: 10px 12px; border-radius: 6px; border: 1px solid var(--border); }

    /* ── Form CSS Tambahan dari Kode 2 ── */
    .form-label-sm {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-sub);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-control-sm-custom {
        width: 100%;
        padding: 8px 11px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13px;
        color: var(--text-main);
        background: var(--slate);
        outline: none;
        transition: border-color .15s;
    }
    .form-control-sm-custom:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }
    .btn-modal-cancel {
        padding: 8px 16px;
        font-size: 13px;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: transparent;
        color: var(--text-sub);
        font-weight: 600;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-cancel:hover { background: var(--slate); }
    .btn-modal-save {
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        background: var(--rs-green);
        color: #fff;
        cursor: pointer;
        transition: background .15s;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.2);
    }
    .btn-modal-save:hover { background: var(--rs-green-hover); }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; font-size:13px; background:var(--rs-green-soft); color:var(--rs-green-hover); border:1px solid #bbf7d0;">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<div class="row">
<div class="col-md-12 mb-3">

    <div class="page-header">
        <div>
            <h1 class="page-title">Maintenance</h1>
        </div>
        <div class="btn-row">
            <button class="btn-solid" data-toggle="modal" data-target="#modalMaintenance">
                <i class="fas fa-plus" style="font-size:11px"></i>
                Maintenance
            </button>
            <a href="{{ url('maintenance/riwayat_maintenance') }}" class="btn-outline-sm">
                <i class="fas fa-history" style="font-size:11px"></i>
                Riwayat
            </a>
            <button id="btn-hapus-terpilih" class="btn-danger-sm">
                <i class="fas fa-trash" style="font-size:11px"></i>
                Hapus Terpilih
                <span id="jumlah-dipilih" class="sel-badge" style="display:none">0</span>
            </button>
        </div>
    </div>

    <div class="toolbar-card">
        <div class="toolbar-row">
            <span class="toolbar-label">Filter Tanggal</span>
            <div style="display:flex;align-items:center;gap:8px;">
                <input type="date" class="date-input" id="filterDateFrom">
                <span class="date-sep">—</span>
                <input type="date" class="date-input" id="filterDateTo">
            </div>
            <div class="divider-v"></div>
            <div class="quick-pills">
                <button class="quick-pill" id="pill-today" onclick="setQuick('today',this)">Hari ini</button>
                <button class="quick-pill" id="pill-week" onclick="setQuick('week',this)">Minggu ini</button>
                <button class="quick-pill" id="pill-month" onclick="setQuick('month',this)">Bulan ini</button>
                <button class="quick-pill active" id="pill-all" onclick="setQuick('all',this)">Semua</button>
            </div>
            <button class="btn-reset" onclick="resetDateFilter()">Reset</button>
        </div>
    </div>

    <div class="filter-dropdown-wrap">
        <span class="toolbar-label">Kategori Perangkat:</span>
        <select id="filterKategoriDropdown" class="select-kategori">
            <option value="all">Semua Kategori</option>
            @foreach($kategoriPerangkat as $namaKategori => $items)
                @php $kat = $items->first(); @endphp
                <option value="{{ $kat->id_kategori }}">{{ $namaKategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="result-info" id="resultInfo">
        Menampilkan {{ $maintenances->unique('id_ruangan')->count() }} ruangan termaintenance
    </div>

   <div class="cards-grid" id="containerMaintenance">

        @php
            $groupedMaintenances = collect($maintenances)->flatten()->groupBy('id_ruangan');
        @endphp

        @foreach($groupedMaintenances as $itemsRuangan)

            @php
                $item = $itemsRuangan->first();

                $teknisi = $itemsRuangan->pluck('nama_teknisi')
                    ->filter()
                    ->unique()
                    ->implode(', ');

                $statuses = $itemsRuangan->pluck('status_pengaduan')->map(fn($s) => strtolower($s))->unique();
            @endphp

            <div class="maintenance-card"
                data-kategori="{{ $item->id_kategori }}"
                data-ruangan="{{ $item->id_ruangan }}"
                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}">

                <input type="checkbox"
                    class="card-checkbox maintenance-check"
                    data-id="{{ $item->id_ruangan }}">

                <div class="mcard-room">
                    {{ $item->nama_ruangan }}
                </div>

                <div class="mcard-date-badge">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    <span style="margin-left:6px; font-weight:600;">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}
                    </span>
                </div>

                <div class="mcard-meta">
                    <i class="fas fa-user-circle"></i>
                    {{ $teknisi ?: '-' }}
                </div>

                <div class="mcard-status-container" style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:8px;">
                    @if($itemsRuangan->whereNotNull('id_pengaduan_masuk')->count() > 0)
                        @foreach($itemsRuangan as $x)
                            @php
                                $status = $x->status_pengaduan ?? 'Unknown';
                                $label = $x->kategori_perangkat ?? 'Perangkat';
                            @endphp

                            @if($status == 'Selesai')

                                <div class="mb-2">
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> {{ $label }}: Selesai
                                    </span>
                                </div>

                            @else

                                @php
                                    $badgeClass = 'badge-secondary';
                                    $icon = 'fas fa-info-circle';

                                    if ($status == 'Diproses') {
                                        $badgeClass = 'badge-warning';
                                        $icon = 'fas fa-tools';
                                    } elseif ($status == 'Pending' || $status == 'Dipending') {
                                        $badgeClass = 'badge-danger';
                                        $icon = 'fas fa-clock';
                                    } elseif ($status == 'Diterima') {
                                        $badgeClass = 'badge-primary';
                                        $icon = 'fas fa-user-check';
                                    } else {
                                        $badgeClass = 'badge-dark';
                                        $icon = 'fas fa-question-circle';
                                    }
                                @endphp

                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge {{ $badgeClass }} mr-2">
                                        <i class="{{ $icon }}"></i> {{ $label }}: {{ $status }}
                                    </span>

                                    {{-- KONDISI PENAMPILAN TOMBOL --}}
                                    @if($status == 'Pending' || $status == 'Dipending')

                                        <button type="button" class="btn btn-sm btn-primary btn-diterima-maintenance mr-1"
                                            data-id="{{ $x->id_pengaduan_masuk }}"
                                            data-kategori="{{ $x->id_kategori }}"
                                            data-status="diterima"> Update
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-pending-maintenance"
                                            data-id="{{ $x->id_pengaduan_masuk }}"
                                            data-kategori="{{ $x->id_kategori }}"
                                            data-status="Pending"> Update
                                        </button>

                                    @elseif($status == 'Diterima')

                                        <button type="button" class="btn btn-sm btn-primary btn-diterima-maintenance mr-1"
                                            data-id="{{ $x->id_pengaduan_masuk }}"
                                            data-kategori="{{ $x->id_kategori }}"
                                            data-status="diterima"> Update
                                        </button>

                                    @elseif($status == 'Diproses')

                                        <button type="button" class="btn btn-sm btn-success btn-selesai-maintenance mr-1"
                                            data-id="{{ $x->id_pengaduan_masuk }}"
                                            data-kategori="{{ $x->id_kategori }}"
                                            data-status="Selesai"> Selesai
                                        </button>

                                    @endif

                                </div>

                            @endif

                        @endforeach
                    @else
                        <span class="badge badge-primary"><i class="fas fa-calendar-check"></i> Jadwal Maintenance</span>
                    @endif
                </div>

                <button type="button"
                    class="btn btn-sm btn-outline-info btn-detail mt-1"
                    data-id="{{ $item->id_maintenance }}">
                    <i class="fas fa-eye"></i> Detail
                </button>
            </div>
        @endforeach
        <div class="empty-state" id="pesanKosong" style="display:none;"><i class="fas fa-inbox mb-2"></i><br>Tidak ada jadwal.</div>
    </div>
</div>

{{-- MODAL TAMBAH MAINTENANCE --}}
<div class="modal fade" id="modalMaintenance" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="mhead purple">
                <h5 class="modal-title">
                    Pilih Aset Yang di Maintenance
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('maintenance/maintenance') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">
                                Kategori Perangkat
                                <span style="font-weight:400;text-transform:none;font-size:11px;color:#9ca3af">(bisa pilih lebih dari satu)</span>
                            </label>
                            <input type="text" id="searchPerangkat" class="form-control-sm-custom mb-2" placeholder="Cari nama kategori...">
                            <div id="listPerangkat" style="max-height:180px;overflow-y:auto;border:1px solid var(--border);border-radius:8px;padding:10px;background:var(--slate);">
                                @foreach($kategoriPerangkat as $namaKategori => $items)
                                <div class="kategori-group mb-1" data-nama="{{ strtolower($namaKategori) }}">
                                    @foreach($items as $kat)
                                    <div class="form-check perangkat-item" style="margin-bottom:4px;">
                                        <input class="form-check-input" type="checkbox" name="id_kategori[]" value="{{ $kat->id_kategori }}" id="kat_{{ $kat->id_kategori }}" style="accent-color:var(--rs-purple)">
                                        <label class="form-check-label" for="kat_{{ $kat->id_kategori }}" style="font-size:13px;color:var(--text-main); font-weight:600;">{{ $namaKategori }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small style="color:var(--rs-purple);font-size:11px;font-weight:700;" id="countPilihan">0 kategori dipilih</small>
                                <small>
                                    <a href="#" id="pilihSemua" style="color:var(--rs-purple);font-size:11px;font-weight:700;">Pilih Semua</a>
                                    <span style="color:var(--border);margin:0 4px">|</span>
                                    <a href="#" id="hapusSemua" style="color:#ef4444;font-size:11px;font-weight:700;">Hapus Semua</a>
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="col-md-12 form-group">
                                <label class="form-label-sm">Ruangan</label>
                                <!-- Search Ruangan -->
                                <input type="text" id="searchRuanganModal" class="form-control-sm-custom mb-2" placeholder="Cari nama ruangan...">

                                <!-- List Ruangan -->
                                <div id="listRuanganModal" style="max-height:180px;overflow-y:auto;border:1px solid var(--border);border-radius:8px;padding:10px;background:var(--slate);">
                                    @foreach($ruangan as $ruang)
                                    <div class="form-check ruangan-item-modal mb-1" data-nama="{{ strtolower($ruang->nama_ruangan) }}">
                                        <!-- name diubah kembali menjadi id_ruangan (bukan array) karena hanya satu -->
                                        <input class="form-check-input check-ruangan" type="checkbox" name="id_ruangan" value="{{ $ruang->id_ruangan }}" id="ruang_{{ $ruang->id_ruangan }}" style="accent-color:var(--rs-purple)">
                                        <label class="form-check-label" for="ruang_{{ $ruang->id_ruangan }}" style="font-size:13px;color:var(--text-main); font-weight:600; cursor:pointer;">
                                            {{ $ruang->nama_ruangan }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Tanggal</label>
                            <input type="date" name="tanggal" id="inputTanggal" class="form-control-sm-custom">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Jam</label>
                            <input type="time" name="jam" id="inputJam" class="form-control-sm-custom">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Nama Teknisi</label>
                            @if(Auth::user()->role == "teknisi")
                                <input type="text" name="nama_teknisi" value="{{ Auth::user()->name }}" class="form-control-sm-custom" readonly style="background:#f1f5f9;color:#64748b;">
                            @else
                                <input type="text" name="nama_teknisi" value="{{ Auth::user()->name }}" class="form-control-sm-custom">
                            @endif
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="form-label-sm">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control-sm-custom" rows="3" placeholder="Deskripsi pekerjaan maintenance..."></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="mhead purple">
                <h5 class="modal-title">Informasi Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="detail-loading" class="text-center py-4">
                    <div class="spinner-border" style="color:var(--rs-purple); width:24px;height:24px;" role="status"></div>
                </div>
                <div id="detail-content" style="display:none;">
                    <div class="detail-list">
                        <div class="detail-item"><div class="detail-label">Ruangan</div><div class="detail-value" id="d-ruangan">-</div></div>
                        <div class="detail-item"><div class="detail-label">Tanggal</div><div class="detail-value" id="d-tanggal">-</div></div>
                        <div class="detail-item"><div class="detail-label">Teknisi</div><div class="detail-value" id="d-teknisi">-</div></div>
                        <div class="detail-item">
                            <div class="detail-label">Kategori</div>
                            <div class="detail-value" id="d-kategori">-</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="d-status">-</div>
                        </div>

                        <div class="detail-item" style="background:transparent; border:none; padding:0;">
                            <div class="detail-label">Deskripsi Maintenance</div>
                            <div class="detail-value-desc" id="d-deskripsi">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" class="btn-tutup-detail" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormTindakan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    Selesaikan Maintenance
                </h5>
            </div>

            <div class="modal-body">

                <form id="formTindakan">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Status Pengaduan</label>
                            <select id="inputStatus" class="form-control" required>
                                <option value="" disabled selected>Pilih Status...</option>
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi Tindakan</label>
                            <textarea id="inputDeskripsiTindakan" class="form-control" rows="4" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-selesai-pengaduan">
                            Simpan & Selesai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    function syncStatusUI() {
        let status = $('#inputStatus').val();
        let btnSubmit = $('#btn-selesai-pengaduan');

        if (status === 'Selesai') {
            btnSubmit
                .removeClass('btn-warning btn-primary')
                .addClass('btn-success')
                .html('<i class="fas fa-check-circle"></i> Tuntas');
        } else {
            btnSubmit
                .removeClass('btn-success btn-primary')
                .addClass('btn-primary')
                .html('<i class="fas fa-save"></i> Simpan');
        }
    }
    $(document).on('click', '.btn-diterima-maintenance', function () {
        let id = $(this).data('id');
        let kategori = $(this).data('kategori');

        $('#inputStatus').html(`
            <option value="Pending">Pending</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
        `);

        $('#inputStatus').val('Pending');

        $('#btn-selesai-pengaduan').data('id', id).data('kategori', kategori);

        syncStatusUI();

        $('#modalFormTindakan').modal('show');
    });

    $(document).on('click', '.btn-pending-maintenance', function () {
        let id = $(this).data('id');
        let kategori = $(this).data('kategori');

        $('#inputStatus').html(`
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
        `);

        $('#inputStatus').val('Diproses');

        $('#btn-selesai-pengaduan').data('id', id).data('kategori', kategori);

        syncStatusUI();

        $('#modalFormTindakan').modal('show');
    });

    $(document).on('click', '.btn-selesai-maintenance', function () {
        let id = $(this).data('id');
        let kategori = $(this).data('kategori');

        $('#inputStatus').html(`
            <option value="Selesai">Selesai</option>
        `);

        $('#inputStatus').val('Selesai').trigger('change');

        $('#btn-selesai-pengaduan')
            .data('id', id)
            .data('kategori', kategori);

        syncStatusUI();

        $('#modalFormTindakan').modal('show');
    });

    $('#formTindakan').on('submit', function (e) {
        e.preventDefault();
        let id = $('#btn-selesai-pengaduan').data('id');
        let kategori = $('#btn-selesai-pengaduan').data('kategori');
        let status = $('#inputStatus').val();
        let deskripsi = $('#inputDeskripsiTindakan').val();

        if (!id || !kategori) {
            alert('Gagal: ID Pengaduan atau ID Kategori tidak valid! Aksi ditolak.');
            return;
        }

        if (!status) {
            alert('Pilih status terlebih dahulu!');
            return;
        }

        //  if (status === 'Selesai' && !deskripsi) {
        //     alert('Deskripsi wajib diisi untuk status Selesai!');
        //     return;
        // }

        fetch(`/maintenance/selesaikan-pengaduan/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status,
                deskripsi_tindakan: status === 'Pending' ? null : deskripsi,
                id_kategori: kategori
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Ditolak: ' + data.message);
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan jaringan atau sistem!');
            console.error(err);
        });
    });
    function fmtDate(d) { return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
    function setQuick(type, el) {
        $('.quick-pill').removeClass('active'); $(el).addClass('active');
        var now = new Date(); var from, to;
        if (type==='today') { from = to = fmtDate(now); }
        else if (type==='week') { var d = new Date(now); d.setDate(d.getDate() - d.getDay()); from = fmtDate(d); var d2 = new Date(d); d2.setDate(d2.getDate() + 6); to = fmtDate(d2); }
        else if (type==='month') { from = fmtDate(new Date(now.getFullYear(), now.getMonth(), 1)); to = fmtDate(new Date(now.getFullYear(), now.getMonth() + 1, 0)); }
        else { from = ''; to = ''; }
        $('#filterDateFrom').val(from); $('#filterDateTo').val(to); applyAllFilters();
    }
    function resetDateFilter() { $('#filterDateFrom').val(''); $('#filterDateTo').val(''); $('.quick-pill').removeClass('active'); $('#pill-all').addClass('active'); applyAllFilters(); }
    $('#filterDateFrom, #filterDateTo').on('change', function () { $('.quick-pill').removeClass('active'); applyAllFilters(); });
    $('#filterKategoriDropdown').on('change', applyAllFilters);

    var mappingKategori = {};
    $.ajax({ url: "{{ url('maintenance/kategori-ruangan') }}", method: 'GET', success: function (data) { mappingKategori = data; } });

    function applyAllFilters() {
        var kategori = $('#filterKategoriDropdown').val();
        var dateFrom = $('#filterDateFrom').val();
        var dateTo = $('#filterDateTo').val();

        var uniqueRooms = new Set();
        var visibleCards = 0;

        $('.maintenance-card').each(function () {
            var cardKat = parseInt($(this).data('kategori'));
            var cardRuang = parseInt($(this).data('ruangan'));
            var cardDate = $(this).data('tanggal');

            var katOk = (kategori === 'all') ? true : (mappingKategori[cardRuang] ? mappingKategori[cardRuang].includes(parseInt(kategori)) && mappingKategori[cardRuang].includes(cardKat) : cardKat === parseInt(kategori));

            var dateOk = true;
            if (dateFrom) dateOk = dateOk && (cardDate >= dateFrom);
            if (dateTo) dateOk = dateOk && (cardDate <= dateTo);

            if (katOk && dateOk) {
                $(this).show();
                uniqueRooms.add(cardRuang);
                visibleCards++;
            } else {
                $(this).hide();
            }
        });

        $('#resultInfo').html('Menampilkan ' + uniqueRooms.size + ' ruangan termaintenance');

        $('#pesanKosong').toggle(visibleCards === 0);
    }

    $(document).on('click', '.btn-detail', function () {
        var id = $(this).data('id');

        console.log('ID DIKLIK =', id);

        if (!id) {
            alert('ID Maintenance tidak ditemukan pada tombol!');
            return;
        }

        $('#detail-loading').html('<div class="spinner-border" style="color:var(--rs-purple); width:24px;height:24px;" role="status"></div>').show();
        $('#detail-content').hide();

        $('#modalDetail').modal('show');

        $.ajax({
            url: "{{ url('maintenance/detail') }}/" + id,
            method: 'GET',
            success: function(data) {

                console.log('DETAIL:', data);

                $('#d-ruangan').text(data.nama_ruangan || '-');
                $('#d-tanggal').text(data.tanggal || '-');
                $('#d-teknisi').text(data.nama_teknisi || '-');
                $('#d-kategori').text(data.nama_kategori || '-');

                $('#d-status').html(data.status_html);

                $('#d-deskripsi').html(data.deskripsi || '-');

                $('#detail-loading').hide();
                $('#detail-content').show();
            },
            error: function(xhr){
                console.error("Error Detail:", xhr.responseText);
                $('#detail-loading').html(
                    '<div class="alert alert-danger m-2">Gagal mengpending data (Error: ' + xhr.status + ')</div>'
                );
            }
        });
    });

    function updateJumlahDipilih() {
        var count = $('.maintenance-check:checked').length;
        if (count > 0) {
            $('#jumlah-dipilih').text(count).show();
        } else {
            $('#jumlah-dipilih').hide();
        }
    }

    $(document).on('change', '.maintenance-check', function () {
        $(this).closest('.maintenance-card').toggleClass('selected', $(this).is(':checked'));
        updateJumlahDipilih();
    });

    $(document).on('click', '.maintenance-card', function (e) {
        if ($(e.target).hasClass('btn-detail-card') || $(e.target).closest('.btn-detail-card').length) return;
        if ($(e.target).hasClass('maintenance-check')) return;
        var checkbox = $(this).find('.maintenance-check');
        checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
    });

    $('#btn-hapus-terpilih').on('click', function () {
        var ids = [];
        $('.maintenance-check:checked').each(function () { ids.push($(this).data('id')); });
        if (ids.length === 0) { alert('Pilih minimal satu data untuk dihapus.'); return; }
        if (!confirm('Hapus ' + ids.length + ' jadwal maintenance yang dipilih?')) return;

        $.ajax({
            url: "{{ url('maintenance/destroy') }}",
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', ids: ids },
            success: function (res) {
                $('.maintenance-check:checked').each(function () {
                    $(this).closest('.maintenance-card').fadeOut(300, function () {
                        $(this).remove();
                        applyAllFilters();
                    });
                });
                updateJumlahDipilih();
                var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px;font-size:13px;background:var(--rs-green-soft);color:var(--rs-green-hover);border:1px solid #bbf7d0;">'
                    + '<i class="fas fa-check-circle mr-1"></i> ' + res.count + ' data berhasil dihapus.'
                    + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>';
                $('.col-md-12').prepend(alertHtml);
            },
            error: function () { alert('Gagal menghapus data. Silakan coba lagi.'); }
        });
    });

    $('#searchPerangkat').on('input', function () {
        var keyword = $(this).val().toLowerCase().trim();
        $('.kategori-group').each(function () {
            var namaKategori = $(this).data('nama') || '';
            if (keyword === '') { $(this).show(); }
            else { $(this).toggle(namaKategori.includes(keyword)); }
        });
        var tampil = $('.kategori-group:visible').length;
        if (keyword !== '') {
            $('#countPilihan').text(tampil + ' hasil ditemukan');
        } else {
            $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
        }
    });

    $(document).on('change', 'input[name="id_kategori[]"]', function () {
        $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
    });

    $('#pilihSemua').on('click', function (e) {
        e.preventDefault();
        $('input[name="id_kategori[]"]:visible').prop('checked', true);
        $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
    });

    $('#hapusSemua').on('click', function (e) {
        e.preventDefault();
        $('input[name="id_kategori[]"]').prop('checked', false);
        $('#countPilihan').text('0 kategori dipilih');
    });

    $('#modalMaintenance').on('hidden.bs.modal', function () {
        $('input[name="id_kategori[]"]').prop('checked', false);
        $('#countPilihan').text('0 kategori dipilih');
        $('#searchPerangkat').val('');
        $('.perangkat-item, .kategori-group').show();
    });

    $('#modalMaintenance').on('show.bs.modal', function () {
        var now    = new Date();
        var tanggal = fmtDate(now);
        var jam    = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        $('#inputTanggal').val(tanggal);
        $('#inputJam').val(jam);
    });

    $(document).on('change', '.check-ruangan', function() {
        if ($(this).is(':checked')) {
            $('.check-ruangan').not(this).prop('checked', false);

            var namaRuang = $(this).closest('.ruangan-item-modal').find('label').text().trim();
            $('#countPilihanRuangan').html('<i class="fas fa-check-circle"></i> Terpilih: ' + namaRuang);
        } else {
            $('#countPilihanRuangan').text('Belum ada ruangan dipilih');
        }
    });

    $('#searchRuanganModal').on('input', function () {
        var keyword = $(this).val().toLowerCase().trim();
        $('.ruangan-item-modal').each(function () {
            var nama = $(this).data('nama') || '';
            $(this).toggle(nama.includes(keyword));
        });
    });

    $('#hapusSemuaRuangan').on('click', function (e) {
        e.preventDefault();
        $('.check-ruangan').prop('checked', false);
        $('#countPilihanRuangan').text('Belum ada ruangan dipilih');
    });

    $('#modalMaintenance').on('hidden.bs.modal', function () {
        $('.check-ruangan').prop('checked', false);
        $('#countPilihanRuangan').text('Belum ada ruangan dipilih');
        $('#searchRuanganModal').val('');
        $('.ruangan-item-modal').show();
    });
</script>
@endsection
