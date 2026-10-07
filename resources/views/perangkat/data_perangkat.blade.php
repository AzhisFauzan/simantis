@extends('layout.page')
@section("judul","Data Perangkat")
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap');

    :root {
        /* Warna Khas */
        --rs-purple:       #6b21a8;
        --rs-purple-hover: #581c87;
        --rs-purple-soft:  #f3e8ff;
        --rs-purple-mid:   #d8b4fe;
        --rs-green:        #16a34a;
        --rs-green-hover:  #15803d;
        --rs-green-soft:   #dcfce7;
        --slate:           #f8fafc;
        --border:          #e2e8f0;
        --text-main:       #0f172a;
        --text-sub:        #64748b;
        --radius:          8px;
    }

    .page-wrapper { font-family: 'DM Sans', sans-serif; }

    /* Header & Navigasi */
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
        display: inline-flex;
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

    /* Styling Tombol */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 8px 18px;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-add:hover { background: var(--rs-green-hover); color: #fff; }

    .btn-back a {
        background: transparent;
        color: var(--text-sub);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-back a:hover {
        background: var(--slate);
        color: var(--rs-purple);
        border-color: var(--rs-purple-mid);
        text-decoration: none;
    }
    .btn-back { margin-bottom: 15px; }

    /* Styling Tabel */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }
    .table-card .card-body { padding: 0; }
    #perangkatTable { margin: 0; border-collapse: collapse; width: 100%; }
    #perangkatTable thead tr { background: var(--rs-purple); }
    #perangkatTable thead th {
        color: #fff;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 10px;
        border: none;
        white-space: nowrap;
    }
    #perangkatTable tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s; }
    #perangkatTable tbody tr:last-child { border-bottom: none; }
    #perangkatTable tbody tr:hover { background: var(--slate); }
    #perangkatTable tbody td {
        font-size: 0.75rem;
        color: var(--text-main);
        padding: 8px 10px;
        border: none;
        vertical-align: middle;
    }

    /* Badge Kondisi */
    .badge-kondisi {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.03em;
    }
    .badge-kondisi.baik { background: var(--rs-green-soft); color: var(--rs-green-hover); }
    .badge-kondisi.rusak { background: #fee2e2; color: #b91c1c; }
    .badge-kondisi.maintenance { background: #fef9c3; color: #92400e; }

    /* Tombol Aksi Tabel */
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
        font-size: 11.5px;
        margin-right: 3px;
    }
    .action-btn.view { color: var(--rs-purple); }
    .action-btn.view:hover { background: var(--rs-purple-soft); border-color: var(--rs-purple-mid); }
    .action-btn.edit { color: #d97706; }
    .action-btn.edit:hover { background: #fffbeb; border-color: #fde68a; }
    .action-btn.move { color: #0891b2; }
    .action-btn.move:hover { background: #ecfeff; border-color: #a5f3fc; }
    .action-btn.delete { color: #dc2626; }
    .action-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }

    /* Styling Dasar Modal */
    .modal-content {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }
    .modal-footer { border-top: 1px solid var(--border); padding: 12px 20px; }
    .modal-body { padding: 20px; }

    .modal-header-add, .modal-header-move { background: var(--rs-purple); padding: 12px 16px; }
    .modal-header-edit { background: #f59e0b; padding: 12px 16px; }
    .modal-header-delete { background: #dc2626; padding: 12px 16px; }
    .modal-header-add .modal-title, .modal-header-move .modal-title,
    .modal-header-edit .modal-title, .modal-header-delete .modal-title,
    .modal-header-add .close, .modal-header-move .close,
    .modal-header-edit .close, .modal-header-delete .close {
        color: #fff; opacity: 1;
    }

    .modal-body label {
        font-size: 0.7rem;
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

    /* Modal Detail Khusus */
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
    .detail-key { font-size: 0.7rem; color: var(--text-sub); min-width: 120px; }
    .detail-val { font-size: 0.75rem; font-weight: 600; color: var(--text-main); text-align: right; }
    .spec-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); padding: 12px 16px; }
    .spec-value { font-size: 0.88rem; color: #334155; line-height: 1.7; white-space: pre-wrap; word-break: break-word; }

    /* Modal Pindah Khusus */
    .move-info-box {
        background: var(--rs-purple-soft);
        border: 1px solid var(--rs-purple-mid);
        border-radius: var(--radius);
        padding: 13px 16px;
        margin-bottom: 14px;
    }
    .move-info-box .move-label {
        font-size: 0.72rem; color: var(--text-sub); text-transform: uppercase;
        letter-spacing: 0.06em; font-weight: 600;
    }
    .move-info-box .move-value { font-size: 0.95rem; font-weight: 700; color: var(--rs-purple-hover); }
    .move-who-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: var(--radius);
        padding: 12px 16px;
        margin-bottom: 14px;
    }

    /* Custom Button Modals */
    .btn-primary-custom {
        background: var(--rs-green); color: #fff; border: none; border-radius: var(--radius);
        padding: 8px 20px; font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: background 0.15s;
    }
    .btn-primary-custom:hover { background: var(--rs-green-hover); color: #fff; }
    .btn-warning-custom { background: #f59e0b; color: #fff; border: none; border-radius: var(--radius); padding: 8px 20px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
    .btn-danger-custom { background: #dc2626; color: #fff; border: none; border-radius: var(--radius); padding: 8px 20px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
    .btn-secondary-custom {
        background: #f1f5f9; color: #475569; border: 1px solid var(--border); border-radius: var(--radius);
        padding: 8px 18px; font-size: 0.75rem; font-weight: 500; cursor: pointer;
    }
    .btn-secondary-custom:hover { background: #e2e8f0; }


    /* --- KUMPULAN ANIMASI MODAL (NATURAL & HUMAN) --- */
    @keyframes scale-up-bounce {
        0% { transform: scale(0.5); opacity: 0; }
        60% { transform: scale(1.15); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes icon-pop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.3) rotate(10deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes fade-slide-up {
        0% { transform: translateY(15px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    .animate-container {
        animation: scale-up-bounce 0.22s cubic-bezier(0.25, 0.8, 0.25, 1) forwards;
    }
    .animate-icon {
        opacity: 0; /* Awal tersembunyi */
        animation: icon-pop 0.28s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.05s forwards;
    }
    .animate-text {
        opacity: 0; /* Awal tersembunyi */
        animation: fade-slide-up 0.22s ease-out 0.08s forwards;
    }
</style>

<div class="page-wrapper">
    <div class="row">
        <div class="col-md-12 mb-3">

            {{-- Header Title --}}
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

            {{-- Tabel Data --}}
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

                                    {{-- Tombol Detail --}}
                                    <button type="button" class="action-btn view" title="Detail"
                                        data-toggle="modal" data-target="#modalDetailperangkat"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        data-nama_kategori="{{ $perangkat->nama_kategori }}"
                                        data-merek="{{ $perangkat->merek }}"
                                        data-kondisi="{{ $perangkat->kondisi }}"
                                        data-tipe="{{ $perangkat->tipe }}"
                                        data-spesifikasi="{{ $perangkat->spesifikasi }}"
                                        data-id_kategori="{{ $perangkat->id_kategori }}"
                                        data-id_ruangan="{{ $perangkat->id_ruangan }}"
                                        data-dipindahkan_oleh="{{ strtoupper($perangkat->dipindahkan_oleh ?? '') }}"
                                        data-role_pemindah="{{ $perangkat->role_pemindah }}"
                                        data-tanggal_pindah="{{ $perangkat->tanggal_pindah }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- Tombol Edit --}}
                                    <button type="button" class="action-btn edit btn-edit" title="Edit"
                                        data-toggle="modal" data-target="#modalEditperangkat"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                        data-id_kategori="{{ $perangkat->id_kategori }}"
                                        data-merek="{{ $perangkat->merek }}"
                                        data-kondisi="{{ $perangkat->kondisi }}"
                                        data-tipe="{{ $perangkat->tipe }}"
                                        data-spesifikasi="{{ $perangkat->spesifikasi }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    {{-- Tombol Pindah --}}
                                    <button type="button" class="action-btn move" title="Pindah"
                                        data-toggle="modal" data-target="#modalMoveperangkat"
                                        data-username="{{ strtoupper(Auth::user()->name) }}"
                                        data-role="{{ Auth::user()->role }}"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" class="action-btn delete" title="Hapus"
                                        data-toggle="modal" data-target="#modalHapusperangkat"
                                        data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                        data-alamat_ip="{{ $perangkat->alamat_ip }}">
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

{{-- Modal Tambah --}}
<div class="modal fade" id="modalPerangkat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-add">
                <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Tambah Perangkat IT</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('perangkat/data_perangkat') }}" method="POST" class="form-ajax">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <input type="hidden" name="id_ruangan" value="{{ $data_ruangan->id_ruangan }}">

                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" class="form-control" placeholder="Contoh: MDN/MG/01..." required oninvalid="this.setCustomValidity('Kode Inventaris wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" class="form-control" placeholder="Isi '-' jika tidak ada IP" required oninvalid="this.setCustomValidity('Alamat IP wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control" required oninvalid="this.setCustomValidity('Kategori wajib dipilih!')" oninput="this.setCustomValidity('')">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" class="form-control" placeholder="Contoh: Dell / HP / Lenovo" required oninvalid="this.setCustomValidity('Merek wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control" required oninvalid="this.setCustomValidity('Kondisi wajib dipilih!')" oninput="this.setCustomValidity('')">
                                <option value="">Pilih Kondisi...</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" class="form-control" placeholder="Isi '-' jika tidak ada tipe" required oninvalid="this.setCustomValidity('Tipe wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB, SSD 256GB" required oninvalid="this.setCustomValidity('Spesifikasi wajib diisi!')" oninput="this.setCustomValidity('')"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button class="btn-primary-custom btn-submit" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
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
                    
                    <div class="detail-row" style="flex-direction: column; align-items: flex-start; gap: 8px;">
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <span class="detail-key">Sudah pernah di maintenance</span>
                            <span class="detail-val" id="detail_maintenance_status">Loading...</span>
                        </div>
                        <div id="detail_maintenance_desc_list" style="display: none; width: 100%; padding: 8px 12px; background: #f8fafc; border-radius: 6px; font-size: 11px; color: #475569;">
                        </div>
                    </div>

                    {{-- Informasi Pemindahan --}}
                    <div id="section_dipindahkan" style="display:none;">
                        <div class="detail-section-title" style="margin-top:12px;">Dipindahkan Oleh</div>
                        <div class="detail-row">
                            <span class="detail-key">Username</span>
                            <span class="detail-val" id="detail_dipindahkan_oleh" style="text-transform: uppercase;">-</span>
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

                {{-- QR Code Section --}}
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

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditperangkat" method="POST" class="form-ajax">
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
                            <input type="text" name="kode_inventaris" id="edit_kode_inventaris" class="form-control" required oninvalid="this.setCustomValidity('Kode Inventaris wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" id="edit_alamat_ip" class="form-control" placeholder="Isi '-' jika tidak ada IP" required oninvalid="this.setCustomValidity('Alamat IP wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" id="edit_id_kategori" class="form-control" required oninvalid="this.setCustomValidity('Kategori wajib dipilih!')" oninput="this.setCustomValidity('')">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" id="edit_merek" class="form-control" required oninvalid="this.setCustomValidity('Merek wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" id="edit_kondisi" class="form-control" required oninvalid="this.setCustomValidity('Kondisi wajib dipilih!')" oninput="this.setCustomValidity('')">
                                <option value="">Pilih Kondisi...</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" id="edit_tipe" class="form-control" placeholder="Isi '-' jika tidak ada tipe" required oninvalid="this.setCustomValidity('Tipe wajib diisi!')" oninput="this.setCustomValidity('')">
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" id="edit_spesifikasi" class="form-control" rows="3" required oninvalid="this.setCustomValidity('Spesifikasi wajib diisi!')" oninput="this.setCustomValidity('')"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-warning-custom btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Pindah --}}
<div class="modal fade" id="modalMoveperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="formMoveperangkat" method="POST" class="form-ajax">
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
                        <select name="id_ruangan_tujuan" id="move_id_ruangan_tujuan" class="form-control" required oninvalid="this.setCustomValidity('Ruangan Tujuan wajib dipilih!')" oninput="this.setCustomValidity('')">
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
                        <input type="datetime-local" name="tanggal_pindah" id="move_tanggal_pindah" class="form-control" required oninvalid="this.setCustomValidity('Tanggal Pindah wajib diisi!')" oninput="this.setCustomValidity('')">
                    </div>

                    <div class="move-who-box">
                        <div style="font-size:0.72rem; color:var(--text-sub); text-transform:uppercase; font-weight:600;">Dipindahkan Oleh</div>
                        <div style="font-weight:700; color:#92400e; font-size:0.9rem; text-transform:uppercase;" id="move_username_display">-</div>
                        <div style="font-size:0.8rem; color:var(--text-sub);" id="move_role_display">-</div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Catatan</label>
                        <textarea name="catatan_pindah" class="form-control" rows="2" placeholder="Wajib diisi. Contoh: Dipindah karena kebutuhan ruang server..." required oninvalid="this.setCustomValidity('Catatan pindah wajib diisi!')" oninput="this.setCustomValidity('')"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom btn-submit">
                        <i class="fas fa-exchange-alt mr-1"></i> Pindahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Alert / Loading / Success --}}
<div class="modal fade" id="modalSuccess" tabindex="-1" style="z-index: 1060;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; text-align: center; padding: 24px 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div class="modal-body p-0">
                <div id="successIconContainer" style="width: 64px; height: 64px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; transition: background 0.3s ease;">
                    <i id="successIcon" class="fas fa-spinner fa-spin" style="font-size: 28px; color: #64748b;"></i>
                </div>
                <h5 id="successTitle" style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Memproses...</h5>
                <p id="successMsg" style="font-size: 13px; color: #64748b; margin-bottom: 0;">Mohon tunggu sebentar.</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapusperangkat" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; text-align: center; padding: 20px;">
            <div class="modal-body">
                <div style="width: 64px; height: 64px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-trash" style="font-size: 28px; color: #dc2626;"></i>
                </div>
                <h5 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Hapus Perangkat?</h5>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Data <strong id="hapus_kategori_perangkat"></strong> yang dihapus tidak bisa dikembalikan.</p>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn-cancel" data-dismiss="modal" style="flex: 1; border:none; background:#f1f5f9; padding: 9px 16px; font-size: 11.5px; font-weight: 700; border-radius: 9px; cursor: pointer; color: #475569;">Batal</button>
                    <form id="formHapus" method="POST" style="margin:0; flex:1;" class="form-ajax">
                        @csrf
                        <button type="submit" class="btn-submit" style="width:100%; padding: 9px 16px; font-size: 11.5px; font-weight: 700; border: none; border-radius: 9px; background: #dc2626; color: #fff; cursor: pointer; transition: background .15s; box-shadow: 0 4px 10px rgba(220, 38, 38, .3);">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Library QR Code JS --}}
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>

    // --- 0. FUNGSI PEMBERSIH BACKDROP (ANTI-NYANGKUT) ---
    // Bootstrap kadang menyisakan .modal-backdrop menumpuk saat modal
    // ditutup & dibuka lagi secara cepat/berurutan (race condition).
    // Fungsi ini dipanggil setiap kali sebelum modal ditampilkan.
    function cleanModalArtifacts() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    }

    // --- 1. FUNGSI LOADING SPINNER (SEBELUM RESPONSE AJAX) ---
    function showLoadingModal() {
        let iconContainer = $('#successIconContainer');
        let icon = $('#successIcon');
        let title = $('#successTitle');
        let msg = $('#successMsg');

        // Reset class animasi agar benar-benar bersih
        iconContainer.removeClass('animate-container');
        icon.removeClass('animate-icon');
        title.removeClass('animate-text');
        msg.removeClass('animate-text');

        // Ganti UI ke Spinner abu-abu
        iconContainer.css('background', '#f1f5f9');
        icon.attr('class', 'fas fa-spinner fa-spin').css({'color': '#64748b', 'opacity': '1'});
        title.text('Memproses...');
        msg.text('Menyimpan data, mohon tunggu...');

        // Sembunyikan modal form yang aktif tanpa animasi transisi
        // (langsung buang class 'show' + backdrop-nya, bukan modal('hide')
        // yang animasinya bisa bentrok dengan modal sukses yang mau muncul)
        $('.modal.show').not('#modalSuccess').each(function () {
            $(this).removeClass('show').css('display', 'none').attr('aria-hidden', 'true');
        });

        cleanModalArtifacts();

        // Tampilkan modal Loading (Mode Statis)
        $('#modalSuccess').modal({backdrop: 'static', keyboard: false});
        $('#modalSuccess').modal('show');
    }

    // --- 2. FUNGSI POP-UP SUKSES / GAGAL ANIMASI BOUNCING ---
    function showSuccessModal(message, type = 'success') {
        let iconContainer = $('#successIconContainer');
        let icon = $('#successIcon');
        let title = $('#successTitle');
        let msg = $('#successMsg');

        // Hapus class animasi dari DOM terlebih dahulu
        iconContainer.removeClass('animate-container');
        icon.removeClass('animate-icon').css('opacity', '0'); // Wajib set ke 0 agar animasi pop-up terasa
        title.removeClass('animate-text').css('opacity', '0');
        msg.removeClass('animate-text').css('opacity', '0');

        // Atur warna dan icon berdasarkan tipe action (Hapus / Simpan / Gagal)
        if (type === 'danger') {
            iconContainer.css('background', '#fee2e2');
            icon.attr('class', 'fas fa-trash').css('color', '#dc2626');
            title.text('Dihapus!');
        } else if (type === 'error') {
            iconContainer.css('background', '#fee2e2');
            icon.attr('class', 'fas fa-times').css('color', '#dc2626');
            title.text('Gagal!');
        } else {
            iconContainer.css('background', '#dcfce7');
            icon.attr('class', 'fas fa-check').css('color', '#16a34a');
            title.text('Berhasil!');
        }
        msg.html(message);

        // Bersihkan backdrop nyangkut dulu, baru pastikan modal tampil
        cleanModalArtifacts();
        if (!$('#modalSuccess').hasClass('show')) {
            $('#modalSuccess').modal({backdrop: 'static', keyboard: false});
            $('#modalSuccess').modal('show');
        }
        // Backdrop harus ada tepat 1 buah untuk modal yang sedang tampil
        if ($('.modal-backdrop').length > 1) {
            $('.modal-backdrop').slice(1).remove();
        }

        // Delay minimal, cuma supaya browser sempat render sebelum animasi jalan
        setTimeout(function() {
            icon.css('opacity', ''); // Lepas inline opacity
            title.css('opacity', '');
            msg.css('opacity', '');

            iconContainer.addClass('animate-container');
            icon.addClass('animate-icon');
            title.addClass('animate-text');
            msg.addClass('animate-text');
        }, 20);

        // Hilangkan pop-up otomatis lebih cepat (error sedikit lebih lama biar sempat dibaca)
        setTimeout(function() {
            $('#modalSuccess').modal('hide');
        }, type === 'error' ? 1800 : 1000);
    }

    // --- 3. SUBMIT SEMUA FORM VIA AJAX (TIDAK RELOAD HALAMAN PENUH) ---
    $(document).on('submit', '.form-ajax', function (e) {
        e.preventDefault();

        const $form = this;

        // Validasi HTML5 bawaan (required, dsb)
        if (!$form.checkValidity()) {
            $form.reportValidity();
            return;
        }

        const $jqForm  = $($form);
        const formData = new FormData($form);
        const actionUrl = $jqForm.attr('action');

        // Tampilkan modal loading (spinner) segera
        showLoadingModal();

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .done(function (res) {
            const isDelete = $jqForm.attr('id') === 'formHapus';
            const type = res.type || (isDelete ? 'danger' : 'success');
            const message = res.message || 'Berhasil diproses.';

            // Tutup semua modal form (Tambah/Edit/Pindah/Hapus) langsung tanpa
            // animasi transisi, lalu bersihkan backdrop sebelum modal sukses
            // muncul, supaya tidak ada backdrop lama yang nyangkut/menumpuk.
            $('.modal.show').not('#modalSuccess').each(function () {
                $(this).removeClass('show').css('display', 'none').attr('aria-hidden', 'true');
            });
            cleanModalArtifacts();

            showSuccessModal(message, type);

            // Refresh isi tabel saja, tanpa reload seluruh halaman
            refreshTabelPerangkat();

            // Reset form supaya bersih untuk input berikutnya
            $form.reset();
        })
        .fail(function (xhr) {
            let message = 'Terjadi kesalahan, silakan coba lagi.';

            if (xhr.responseJSON) {
                if (xhr.responseJSON.errors) {
                    // Error validasi Laravel (422)
                    message = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
            }

            showSuccessModal(message, 'error');
        });
    });

    // --- 4. REFRESH TABEL PERANGKAT TANPA RELOAD HALAMAN PENUH ---
    function refreshTabelPerangkat() {
        $.get(window.location.href, function (html) {
            const newTbody = $(html).find('#perangkatTable tbody').html();
            $('#perangkatTable tbody').html(newTbody);
        });
    }

    // Membersihkan body & backdrop setiap kali modal sukses ditutup
    // (baik auto-hide via timer maupun ditutup manual oleh user)
    $('#modalSuccess').on('hidden.bs.modal', function () {
        cleanModalArtifacts();
    });

    // --- 5. Konstanta Global ---
    const baseUrl = "{{ url('') }}";
    let teksLabelQRCode = "";

    // --- 6. Event Listener Modal Detail & QR Code ---
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
        const btnDownload = document.getElementById('btnDownloadQRCode');

        if(kodeInventaris !== '-') {
            teksLabelQRCode = kodeInventaris + " - " + namaKategori + " - " + merek;

            QRCode.toDataURL(teksLabelQRCode, {
                errorCorrectionLevel: 'M',
                type: 'image/jpeg',
                quality: 1,
                margin: 2,
                width: 250,
                color: { dark: "#0f172a", light: "#ffffff" }
            }, function (err, url) {
                if (err) throw err;
                imgDetail.src = url;
                imgDetail.style.display = "block";
                btnDownload.style.display = "inline-block";
            });
        } else {
            imgDetail.style.display = "none";
            btnDownload.style.display = "none";
        }

        const kondisi = btn.data('kondisi') || '-';
        const badgeMap = {
            'Baik':        '<span class="badge-kondisi baik">Baik</span>',
            'Rusak':       '<span class="badge-kondisi rusak">Rusak</span>',
            'Maintenance': '<span class="badge-kondisi maintenance">Maintenance</span>',
        };
        modal.find('#detail_kondisi_badge').html(badgeMap[kondisi] || kondisi);
        modal.find('#detail_spesifikasi').text(btn.data('spesifikasi') || '-');
        
        const idKategori = btn.data('id_kategori');
        const idRuangan = btn.data('id_ruangan');
        
        const mainStatusEl = modal.find('#detail_maintenance_status');
        const mainDescList = modal.find('#detail_maintenance_desc_list');
        
        mainStatusEl.html('<i class="fas fa-spinner fa-spin"></i> Mengecek...');
        mainDescList.hide().empty();

        if(idKategori && idRuangan) {
            $.get(baseUrl + '/perangkat/riwayat-maintenance/' + idKategori + '/' + idRuangan, function(res) {
                if(res.status === 'success' && res.data && res.data.length > 0) {
                    mainStatusEl.text('Ya (' + res.data.length + ' kali)');
                    
                    let descHtml = '<ul style="margin:0; padding-left:16px;">';
                    res.data.forEach(function(item) {
                        let tgl = '-';
                        if(item.tanggal) {
                            let d = new Date(item.tanggal);
                            tgl = d.toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'});
                        }
                        let dtext = item.deskripsi ? item.deskripsi : 'Tidak ada keterangan';
                        descHtml += '<li style="margin-bottom:2px;"><b>' + tgl + '</b>: ' + dtext + '</li>';
                    });
                    descHtml += '</ul>';
                    mainDescList.html(descHtml).show();
                } else {
                    mainStatusEl.text('Belum pernah');
                }
            }).fail(function() {
                mainStatusEl.text('Gagal memuat');
            });
        } else {
            mainStatusEl.text('Belum pernah');
        }

        const dipindahkanOleh = btn.data('dipindahkan_oleh') || '';
        const rolePemindah    = btn.data('role_pemindah')    || '';
        const tanggalPindah   = btn.data('tanggal_pindah')   || '';

        if (dipindahkanOleh) {
            modal.find('#detail_dipindahkan_oleh').text(dipindahkanOleh);
            modal.find('#detail_role_pemindah').text(rolePemindah);

            if (tanggalPindah) {
                const dt = new Date(tanggalPindah);
                const formatted = dt.toLocaleString('id-ID', {
                    day: '2-digit', month: 'long', year: 'numeric',
                    hour: '2-digit', minute: '2-digit',
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

    // --- 7. Event Listener Modal Edit ---
    $('#modalEditperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        modal.find('#edit_kode_inventaris').val(btn.data('kode_inventaris') || '');
        modal.find('#edit_alamat_ip').val(btn.data('alamat_ip')   || '');
        modal.find('#edit_id_kategori').val(btn.data('id_kategori') || '');
        modal.find('#edit_merek').val(btn.data('merek') || '');
        modal.find('#edit_kondisi').val(btn.data('kondisi') || '');
        modal.find('#edit_tipe').val(btn.data('tipe') || '');
        modal.find('#edit_spesifikasi').val(btn.data('spesifikasi') || '');

        $('#formEditperangkat').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/update'
        );
    });

    // --- 8. Event Listener Modal Pindah ---
    $('#modalMoveperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        const idPerangkat    = btn.data('id_perangkat') || '';
        const kodeInventaris = btn.data('kode_inventaris') || '-';
        const namaPerangkat  = btn.data('kategori_perangkat') || '-';

        modal.find('#move_kategori_perangkat').text(namaPerangkat);
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

    // --- 9. Event Listener Modal Hapus ---
    $('#modalHapusperangkat').on('show.bs.modal', function(e) {
        const btn = $(e.relatedTarget);
        $(this).find('#hapus_kategori_perangkat').text(btn.data('kategori_perangkat') || '');

        $('#formHapus').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/delete'
        );
    });

    // --- 10. Fitur Pencarian / Sidebar (Bawaan Framework) ---
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
