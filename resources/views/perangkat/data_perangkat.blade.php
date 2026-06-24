@extends('layout.page')
@section("judul","Data Perangkat")
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap');

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

    .page-wrapper { font-family: 'DM Sans', sans-serif; }

    /* ── Header bar ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .page-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-main);
        margin: 0;
    }
    .room-label {
        display:inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--rs-purple);
        background: var(--rs-purple-soft);
        border: 1px solid var(--rs-purple-mid);
        border-radius: 20px;
        padding: 5px 14px;
        margin-left: 12px;
    }

    /* Tombol Utama (Tambah) - Hijau RS */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-add:hover { background: var(--rs-green-hover); color: #fff; }

    /* Tombol Kembali - Style Outline yang bersih */
    .btn-back a {
        background: transparent;
        color: var(--text-sub);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-back a:hover {
        background: var(--slate);
        color: var(--rs-purple);
        border-color: var(--rs-purple-mid);
        text-decoration: none;
    }
    .btn-back {
        margin-bottom: 15px;
    }

    /* Alert Success */
    .alert-success {
        background-color: var(--rs-green-soft);
        color: var(--rs-green-hover);
        border: 1px solid #bbf7d0;
        border-radius: var(--radius);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* ── Table card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
    }
    .table-card .card-body { padding: 0; }

    #perangkatTable { margin: 0; border-collapse: collapse; width: 100%; }
    #perangkatTable thead tr {
        background: var(--rs-purple);
    }
    #perangkatTable thead th {
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 14px 14px;
        border: none;
        white-space: nowrap;
    }
    #perangkatTable tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.12s;
    }
    #perangkatTable tbody tr:last-child { border-bottom: none; }
    #perangkatTable tbody tr:hover { background: var(--slate); }
    #perangkatTable tbody td {
        font-size: 0.85rem;
        color: var(--text-main);
        padding: 12px 14px;
        border: none;
        vertical-align: middle;
    }

    /* ── Kondisi badges ── */
    .badge-kondisi {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.03em;
    }
    .badge-kondisi.baik        { background: var(--rs-green-soft); color: var(--rs-green-hover); }
    .badge-kondisi.rusak       { background: #fee2e2; color: #b91c1c; }
    .badge-kondisi.maintenance { background: #fef9c3; color: #92400e; }

    /* ── Action buttons ── */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: 1px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: background 0.13s, border-color 0.13s;
        font-size: 13px;
        margin-right: 3px;
    }
    .action-btn.view   { color: var(--rs-purple); }
    .action-btn.view:hover   { background: var(--rs-purple-soft); border-color: var(--rs-purple-mid); }
    .action-btn.edit   { color: #d97706; }
    .action-btn.edit:hover   { background: #fffbeb; border-color: #fde68a; }
    .action-btn.move   { color: #0891b2; }
    .action-btn.move:hover   { background: #ecfeff; border-color: #a5f3fc; }
    .action-btn.delete { color: #dc2626; }
    .action-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }

    /* ── Modal base ── */
    .modal-content {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }
    .modal-footer { border-top: 1px solid var(--border); padding: 12px 20px; }
    .modal-body   { padding: 20px; }

    /* ── Modal Headers ── */
    .modal-header-add, .modal-header-move {
        background: var(--rs-purple);
        padding: 16px 20px;
    }
    .modal-header-edit {
        background: #f59e0b;
        padding: 16px 20px;
    }
    .modal-header-delete {
        background: #dc2626;
        padding: 16px 20px;
    }
    .modal-header-add .modal-title, .modal-header-move .modal-title,
    .modal-header-edit .modal-title, .modal-header-delete .modal-title,
    .modal-header-add .close, .modal-header-move .close,
    .modal-header-edit .close, .modal-header-delete .close {
        color: #fff; opacity: 1;
    }

    /* modal form */
    .modal-body label {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }
    .modal-body .form-control {
        border-radius: 8px;
        border: 1px solid var(--border);
        font-size: 0.88rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-main);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .modal-body .form-control:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107,33,168,0.1);
    }

    /* ── Modal Detail ── */
    .detail-section-title {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--rs-purple);
        font-weight: 700;
        margin-bottom: 10px;
        border-bottom: 1.5px solid var(--rs-purple-mid);
        padding-bottom: 5px;
    }
    .detail-card {
        background: var(--slate);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 16px;
        margin-bottom: 14px;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 6px 0;
        border-bottom: 1px solid var(--border);
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-key {
        font-size: 0.78rem;
        color: var(--text-sub);
        min-width: 120px;
    }
    .detail-val {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-main);
        text-align: right;
    }
    .spec-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 12px 16px;
    }
    .spec-value {
        font-size: 0.88rem;
        color: #334155;
        line-height: 1.7;
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* ── Move info box ── */
    .move-info-box {
        background: var(--rs-purple-soft);
        border: 1px solid var(--rs-purple-mid);
        border-radius: var(--radius);
        padding: 13px 16px;
        margin-bottom: 14px;
    }
    .move-info-box .move-label {
        font-size: 0.72rem;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 600;
    }
    .move-info-box .move-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--rs-purple-hover);
    }
    .move-who-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: var(--radius);
        padding: 12px 16px;
        margin-bottom: 14px;
    }

    /* ── Buttons ── */
    .btn-primary-custom {
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-primary-custom:hover { background: var(--rs-green-hover); color: #fff; }

    .btn-warning-custom {
        background: #f59e0b;
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-danger-custom {
        background: #dc2626;
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-secondary-custom:hover { background: #e2e8f0; }
</style>

<div class="page-wrapper">
    <div class="row">
        <div class="col-md-12 mb-3">

            <div class="page-header">
                <div style="display:flex; align-items:center;">
                    <h1 class="page-title">
                        <i class="fas fa-desktop mr-2" style="font-size:1rem; color: var(--rs-purple);"></i>Data Perangkat IT
                    </h1>
                    <div class="room-label">
                        <i class="fas fa-door-open" style="font-size:12px;"></i>
                        {{ $data_ruangan->nama_ruangan }}
                    </div>
                </div>
                <button class="btn-add" data-toggle="modal" data-target="#modalPerangkat">
                    <i class="fas fa-plus" style="font-size:11px;"></i> Tambah Perangkat
                </button>
            </div>

            <div class="btn-back">
                <a href="{{ url('/ruangan/ruangan')}}">
                    <i class="fas fa-long-arrow-alt-left mr-1"></i> Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-card">
                <div class="card-body">
                    <table class="table table-sm" id="perangkatTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Inventaris</th>
                                <th>Alamat IP</th>
                                <th>Kategori</th>
                                <th>Merek</th>
                                <th class="text-center">Kondisi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_perangkat as $perangkat)
                            <tr id="row-{{ $perangkat->id_perangkat }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td style="font-weight:600; color: var(--rs-purple);">{{ $perangkat->kode_inventaris }}</td>
                                <td style="font-family:monospace; color: var(--text-sub);">{{ $perangkat->alamat_ip ? $perangkat->alamat_ip : '-' }}</td>
                                <td>{{ $perangkat->nama_kategori }}</td>
                                <td>{{ $perangkat->merek }}</td>
                                <td class="text-center">
                                    @if($perangkat->kondisi == 'Baik')
                                        <span class="badge-kondisi baik">Baik</span>
                                    @elseif($perangkat->kondisi == 'Rusak')
                                        <span class="badge-kondisi rusak">Rusak</span>
                                    @else
                                        <span class="badge-kondisi maintenance">Maintenance</span>
                                    @endif
                                </td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <button type="button"
                                        class="action-btn view"
                                        data-toggle="modal"
                                        data-target="#modalDetailperangkat"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        data-nama_kategori="{{ $perangkat->nama_kategori }}"
                                        data-merek="{{ $perangkat->merek }}"
                                        data-kondisi="{{ $perangkat->kondisi }}"
                                        data-tipe="{{ $perangkat->tipe }}"
                                        data-spesifikasi="{{ $perangkat->spesifikasi }}"
                                        data-dipindahkan_oleh="{{ $perangkat->dipindahkan_oleh }}"
                                        data-role_pemindah="{{ $perangkat->role_pemindah }}"
                                        data-tanggal_pindah="{{ $perangkat->tanggal_pindah }}"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <button type="button"
                                        class="action-btn edit btn-edit"
                                        data-toggle="modal"
                                        data-target="#modalEditperangkat"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        data-id_kategori="{{ $perangkat->id_kategori }}"
                                        data-merek="{{ $perangkat->merek }}"
                                        data-kondisi="{{ $perangkat->kondisi }}"
                                        data-tipe="{{ $perangkat->tipe }}"
                                        data-spesifikasi="{{ $perangkat->spesifikasi }}"
                                        title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button type="button"
                                        class="action-btn move"
                                        data-toggle="modal"
                                        data-target="#modalMoveperangkat"
                                        data-username="{{ Auth::user()->name }}"
                                        data-role="{{ Auth::user()->role }}"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        title="Pindah">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>

                                    <button type="button"
                                        class="action-btn delete"
                                        data-toggle="modal"
                                        data-target="#modalHapusperangkat"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────── MODAL TAMBAH ─────────────── --}}
<div class="modal fade" id="modalPerangkat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-add">
                <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Tambah Perangkat IT</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('perangkat/data_perangkat') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <input type="hidden" name="id_ruangan" value="{{ $data_ruangan->id_ruangan }}">
                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" class="form-control" placeholder="Contoh: MDN/MG/01...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" class="form-control" placeholder="Contoh: 192.168...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" class="form-control" placeholder="Contoh: Dell / HP / Lenovo">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" value="-" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB, SSD 256GB"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button class="btn-primary-custom" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─────────────── MODAL DETAIL ─────────────── --}}
<div class="modal fade" id="modalDetailperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header modal-header-add">
                <h5 class="modal-title">Detail Perangkat</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="detail-section-title"><i class="fas fa-info-circle mr-1"></i> Informasi Umum</div>
                <div class="detail-card">
                    <div class="detail-row">
                        <span class="detail-key">Kode Inventaris</span>
                        <span class="detail-val" id="detail_kode_inventaris">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Alamat IP</span>
                        <span class="detail-val" id="detail_alamat_ip" style="font-family:monospace;">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Kategori</span>
                        <span class="detail-val" id="detail_nama_kategori">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Merek</span>
                        <span class="detail-val" id="detail_merek">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Tipe</span>
                        <span class="detail-val" id="detail_tipe">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Kondisi</span>
                        <span class="detail-val" id="detail_kondisi_badge">-</span>
                    </div>
                    <div id="section_dipindahkan" style="display:none;">
                        <div class="detail-section-title" style="margin-top:12px;">Dipindahkan Oleh</div>
                        <div class="detail-row">
                            <span class="detail-key">Username</span>
                            <span class="detail-val" id="detail_dipindahkan_oleh">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key">Role</span>
                            <span class="detail-val" id="detail_role_pemindah">-</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key">Tanggal Pindah</span>
                            <span class="detail-val" id="detail_tanggal_pindah">-</span>
                        </div>
                    </div>
                </div>
                <div class="detail-section-title"><i class="fas fa-microchip mr-1"></i> Spesifikasi</div>
                <div class="spec-card">
                    <div class="spec-value" id="detail_spesifikasi">-</div>
                </div>
                <div class="detail-row" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px 0; border-bottom: 1.5px dashed var(--border);">

                    <img id="detail_qrcode_img" alt="QR Code" style="max-width: 200px; border-radius: 6px; display: none; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">

                    <button type="button" id="btnDownloadQRCode" class="btn-primary-custom mt-3" style="display: none; font-size: 0.8rem; padding: 6px 14px; border-radius: 20px;">
                        <i class="fas fa-download mr-1"></i> Download QR Code
                    </button>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-custom" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- ─────────────── MODAL EDIT ─────────────── --}}
<div class="modal fade" id="modalEditperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditperangkat" method="POST">
                @csrf
                <div class="modal-header modal-header-edit">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt mr-2"></i>Edit Perangkat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_ruangan" id="edit_id_ruangan" value="{{ $data_ruangan->id_ruangan }}">
                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" id="edit_kode_inventaris" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" id="edit_alamat_ip" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" id="edit_id_kategori" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" id="edit_merek" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" id="edit_kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" id="edit_tipe" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" id="edit_spesifikasi" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-warning-custom">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─────────────── MODAL PINDAH ─────────────── --}}
<div class="modal fade" id="modalMoveperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="formMoveperangkat" method="POST">
                @csrf
                <div class="modal-header modal-header-move">
                    <h5 class="modal-title"><i class="fas fa-exchange-alt mr-2"></i>Pindah Perangkat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="move-info-box">
                        <div class="move-label">Perangkat yang Dipindah</div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div>
                                <div class="move-value" id="move_kategori_perangkat">-</div>
                                <div style="font-size:0.8rem; color:var(--text-sub);" id="move_kode_inventaris_display">-</div>
                            </div>
                            <span style="background:var(--rs-purple-mid); color:var(--rs-purple-hover); font-size:0.75rem; font-weight:700; padding:4px 12px; border-radius:20px;">
                                <i class="fas fa-barcode mr-1"></i>
                                <span id="move_kode_badge">-</span>
                            </span>
                        </div>
                    </div>

                    <div class="text-center mb-3" style="font-size:1.3rem; color:var(--rs-purple);">
                        <i class="fas fa-arrow-down"></i>
                    </div>

                    <div class="form-group">
                        <label>Ruangan Tujuan</label>
                        <select name="id_ruangan_tujuan" id="move_id_ruangan_tujuan" class="form-control" required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach($data_semua_ruangan as $ruangan)
                                @if($ruangan->id_ruangan != $data_ruangan->id_ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                                @endif
                            @endforeach
                        </select>
                        <small class="text-muted">Ruangan saat ini tidak ditampilkan sebagai pilihan tujuan.</small>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pindah</label>
                        <input type="datetime-local" name="tanggal_pindah" id="move_tanggal_pindah" class="form-control" required>
                    </div>

                    <div class="move-who-box">
                        <div style="font-size:0.72rem; color:var(--text-sub); text-transform:uppercase; font-weight:600;">Dipindahkan Oleh</div>
                        <div style="font-weight:700; color:#92400e; font-size:0.9rem;" id="move_username_display">-</div>
                        <div style="font-size:0.8rem; color:var(--text-sub);" id="move_role_display">-</div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Catatan <span style="font-weight:400; text-transform:none; color:#94a3b8;">(opsional)</span></label>
                        <textarea name="catatan_pindah" class="form-control" rows="2" placeholder="Contoh: Dipindah karena kebutuhan ruang server..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-exchange-alt mr-1"></i> Pindahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─────────────── MODAL HAPUS ─────────────── --}}
<div class="modal fade" id="modalHapusperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-header-delete">
                <h5 class="modal-title"><i class="fas fa-trash mr-2"></i>Hapus Perangkat</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center" style="padding: 24px 20px;">
                <div style="width:52px; height:52px; border-radius:50%; background:#fee2e2; display:flex; align-items:center; justify-content:center; margin: 0 auto 14px;">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size:1.3rem;"></i>
                </div>
                <p style="font-size:0.9rem; color:var(--text-main); margin:0;">
                    Yakin ingin menghapus perangkat <strong id="hapus_kategori_perangkat"></strong>?
                </p>
            </div>
            <div class="modal-footer justify-content-center" style="gap:8px;">
                <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    <button type="submit" class="btn-danger-custom">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
    const baseUrl = "{{ url('') }}";

    let teksLabelQRCode = "";

    $('#modalDetailperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        const kodeInventaris = btn.data('kode_inventaris') || '-';
        const namaKategori   = btn.data('nama_kategori') || '-';
        const merek          = btn.data('merek') || '-';

        modal.find('#detail_kode_inventaris').text(kodeInventaris);
        modal.find('#detail_alamat_ip').text(btn.data('alamat_ip') || '-');
        modal.find('#detail_nama_kategori').text(namaKategori);
        modal.find('#detail_merek').text(merek);
        modal.find('#detail_tipe').text(btn.data('tipe') || '-');

        const imgDetail = document.getElementById('detail_qrcode_img');
        const btnDownload = document.getElementById('btnDownloadQRCode'); // Ubah ID-nya

        if(kodeInventaris !== '-') {
            teksLabelQRCode = kodeInventaris + " - " + namaKategori + " - " + merek;

            QRCode.toDataURL(teksLabelQRCode, {
                errorCorrectionLevel: 'M',
                type: 'image/jpeg',
                quality: 1,
                margin: 2,
                width: 250,
                color: {
                    dark: "#0f172a",
                    light: "#ffffff"
                }
            }, function (err, url) {
                if (err) throw err;
                imgDetail.src = url;
                imgDetail.style.display = "block";
                btnDownload.style.display = "inline-block"; // Munculkan tombol download
            });

        } else {
            imgDetail.style.display = "none";
            btnDownload.style.display = "none"; // Sembunyikan tombol download
        }

        // --- Render data kondisi & pindah (Tetap sama seperti kodemu sebelumnya) ---
        const kondisi = btn.data('kondisi') || '-';
        const badgeMap = {
            'Baik':        '<span class="badge-kondisi baik">Baik</span>',
            'Rusak':       '<span class="badge-kondisi rusak">Rusak</span>',
            'Maintenance': '<span class="badge-kondisi maintenance">Maintenance</span>',
        };
        modal.find('#detail_kondisi_badge').html(badgeMap[kondisi] || kondisi);
        modal.find('#detail_spesifikasi').text(btn.data('spesifikasi') || '-');

        const dipindahkanOleh = btn.data('dipindahkan_oleh') || '';
        const rolePemindah    = btn.data('role_pemindah')    || '';
        const tanggalPindah   = btn.data('tanggal_pindah')   || '';

        if (dipindahkanOleh) {
            modal.find('#detail_dipindahkan_oleh').text(dipindahkanOleh);
            modal.find('#detail_role_pemindah').text(rolePemindah);
            if (tanggalPindah) {
                const dt = new Date(tanggalPindah);
                const formatted = dt.toLocaleString('id-ID', {
                    day:    '2-digit', month:  'long', year:   'numeric',
                    hour:   '2-digit', minute: '2-digit',
                });
                modal.find('#detail_tanggal_pindah').text(formatted);
            } else {
                modal.find('#detail_tanggal_pindah').text('-');
            }
            modal.find('#section_dipindahkan').show();
        } else {
            modal.find('#section_dipindahkan').hide();
        }
    });

    document.getElementById('btnDownloadQRCode').addEventListener('click', function() {
        const imgSrc = document.getElementById('detail_qrcode_img').src;
        const kodeInv = document.getElementById('detail_kode_inventaris').innerText;

        if (!imgSrc || imgSrc === '') return;

        const downloadLink = document.createElement('a');
        downloadLink.href = imgSrc;

        const namaFileAman = kodeInv.replace(/[^a-zA-Z0-9]/g, '_');
        downloadLink.download = 'QRCode_' + namaFileAman + '.jpg';

        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });

    $('#modalEditperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        modal.find('#edit_kode_inventaris').val(btn.data('kode_inventaris') || '');
        modal.find('#edit_alamat_ip').val(btn.data('alamat_ip')   || '');
        modal.find('#edit_id_kategori').val(btn.data('id_kategori')         || '');
        modal.find('#edit_merek').val(btn.data('merek')                       || '');
        modal.find('#edit_kondisi').val(btn.data('kondisi')                 || '');
        modal.find('#edit_tipe').val(btn.data('tipe')                       || '');
        modal.find('#edit_spesifikasi').val(btn.data('spesifikasi')         || '');

        $('#formEditperangkat').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/update'
        );
    });

    $('#modalMoveperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        const idPerangkat    = btn.data('id_perangkat')    || '';
        const kodeInventaris = btn.data('kode_inventaris') || '-';
        const namaPerangkat  = btn.data('kategori_perangkat')  || '-';

        modal.find('#move_kode_perangkat').text(namaPerangkat);
        modal.find('#move_kode_inventaris_display').text('Kode: ' + kodeInventaris);
        modal.find('#move_kode_badge').text(kodeInventaris);
        modal.find('#move_username_display').text(btn.data('username') || '-');
        modal.find('#move_role_display').text('Role: ' + (btn.data('role') || '-'));

        const now = new Date();
        const localDT = now.getFullYear() + '-' +
            String(now.getMonth()+1).padStart(2,'0') + '-' +
            String(now.getDate()).padStart(2,'0') + 'T' +
            String(now.getHours()).padStart(2,'0') + ':' +
            String(now.getMinutes()).padStart(2,'0');
        modal.find('#move_tanggal_pindah').val(localDT);

        modal.find('#move_id_ruangan_tujuan').val('');
        modal.find('textarea[name="catatan_pindah"]').val('');

        $('#formMoveperangkat').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + idPerangkat + '/move'
        );
    });

    $('#modalHapusperangkat').on('show.bs.modal', function(e) {
        const btn = $(e.relatedTarget);
        $(this).find('#hapus_kategori_perangkat').text(btn.data('kategori_perangkat') || '');
        $('#formHapus').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/delete'
        );
    });

    const inputSearch = document.getElementById('inputSearch');
    if (inputSearch) {
        let debounceTimer;
        inputSearch.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                document.getElementById('formSearch').submit();
            }, 500);
        });
    }

    document.documentElement.style.setProperty('--sidebar-transition', 'none');
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.sidebar').style.transition = 'none';
        document.body.classList.add('sidebar-toggled');
        document.querySelector('.sidebar').classList.add('toggled');
        setTimeout(function() {
            document.querySelector('.sidebar').style.transition = '';
        }, 100);
    });
</script>

@endsection
