@extends('layout.page')
@section("judul","Data Ruangan")
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

    * { box-sizing: border-box; }
    .page-wrapper { font-family: 'DM Sans', sans-serif; }

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
    .page-subtitle {
        font-size: 13px;
        color: var(--text-sub);
        margin-top: 2px;
    }

    /* Tombol Utama (Tambah) - Hijau RS */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--rs-green); /* Warna Solid */
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: opacity .15s, transform .15s, background .15s;
        box-shadow: 0 4px 12px rgba(22, 163, 74, .35);
    }
    .btn-add:hover { background: var(--rs-green-hover); transform: translateY(-1px); color: #fff; }

    /* ── Stat Card (Ungu RS Solid) ── */
    .stat-card {
        background: var(--rs-purple); /* Warna Solid */
        border-radius: 12px;
        padding: 16px 20px;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(107, 33, 168, .25);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        right: -20px; bottom: -20px;
        width: 100px; height: 100px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: 40px; bottom: -36px;
        width: 70px; height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
    }
    .stat-label {
        font-size: 11px;
        font-weight: 600;
        opacity: .8;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        line-height: 1;
    }
    .stat-icon {
        width: 48px; height: 48px;
        background: rgba(255,255,255,.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        position: relative;
        z-index: 1;
        flex-shrink: 0;
    }

    /* ── Search Bar ── */
    .search-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }
    .search-box {
        position: relative;
        width: 300px;
    }
    .search-box i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #b0b8c9;
        font-size: 13px;
        z-index: 1;
    }
    .search-input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-main);
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .search-input:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107,33,168,.12);
    }
    .btn-clear {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        background: transparent;
        color: var(--text-sub);
        text-decoration: none;
        font-size: 12px;
        transition: all .15s;
        flex-shrink: 0;
    }
    .btn-clear:hover { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 0.5px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,.04);
        margin-bottom: 16px;
    }
    .table-card .card-body { padding: 0; }

    #ruanganTable {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }

    /* Tema Tabel Sama Persis dengan Kategori Perangkat */
    #ruanganTable thead tr {
        background: var(--rs-purple);
    }
    #ruanganTable thead th {
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 14px 14px;
        border: none;
        white-space: nowrap;
    }
    #ruanganTable tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.12s;
    }
    #ruanganTable tbody tr:last-child { border-bottom: none; }
    #ruanganTable tbody tr:hover { background: var(--slate); }

    #ruanganTable tbody td {
        font-size: 0.85rem;
        color: var(--text-main);
        padding: 12px 14px;
        border: none;
        vertical-align: middle;
    }

    /* ── Action buttons ── */
    .action-buttons { display: inline-flex; gap: 5px; justify-content: center; }
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px; height: 32px;
        border-radius: 7px;
        border: 1px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: all .15s;
        font-size: 13px;
    }
    .btn-icon-edit   { color: #d97706; }
    .btn-icon-edit:hover  { background: #fef3c7; border-color: #fde68a; }
    .btn-icon-danger { color: #dc2626; }
    .btn-icon-danger:hover { background: #fef2f2; border-color: #fecaca; }

    /* ── Pagination ── */
    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        margin-bottom: 80px;
    }
    .pagination-info {
        font-size: 12px;
        color: var(--text-sub);
    }
    .pagination-wrap .pagination { margin: 0; }
    .pagination-wrap .page-link {
        border-radius: 8px !important;
        margin: 0 2px;
        font-size: 12px;
        font-weight: 500;
        color: #374151;
        border: 0.5px solid var(--border);
        padding: 5px 11px;
    }
    .pagination-wrap .page-item.active .page-link {
        background: var(--rs-purple); /* Warna Solid */
        border-color: transparent;
        color: #fff;
    }
    .pagination-wrap .page-item.disabled .page-link { opacity: .4; }

    /* ── Modals (Solid Colors) ── */
    .modal-content {
        border-radius: 14px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,.12);
        font-family: 'DM Sans', sans-serif;
    }
    .modal-header-main {
        background: var(--rs-purple);
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header-amber {
        background: #d97706;
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header-red {
        background: #dc2626;
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title-custom {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    .modal-close-btn {
        width: 28px; height: 28px;
        background: rgba(255,255,255,.2);
        border: none; border-radius: 50%;
        color: #fff; font-size: 18px; line-height: 1;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .modal-close-btn:hover { background: rgba(255,255,255,.35); }

    .modal-body   { padding: 22px 24px; }
    .modal-footer { border-top: 0.5px solid #f0f0f0; padding: 14px 24px; }

    .form-label-custom {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-sub);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-control-custom {
        width: 100%;
        padding: 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-main);
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        appearance: none;
        -webkit-appearance: none;
    }
    .form-control-custom:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107,33,168,.12);
    }
    select.form-control-custom {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .btn-cancel {
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 500;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        background: transparent;
        color: var(--text-sub);
        cursor: pointer;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #f3f4f6; }

    /* Tombol Submit Modal */
    .btn-modal-main {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        background: var(--rs-green); /* Warna Solid */
        color: #fff;
        cursor: pointer;
        transition: background .15s;
        box-shadow: 0 4px 10px rgba(22, 163, 74, .3);
    }
    .btn-modal-main:hover { background: var(--rs-green-hover); }

    .btn-modal-amber {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        background: #d97706; /* Warna Solid */
        color: #fff;
        cursor: pointer;
        transition: opacity .15s;
        box-shadow: 0 4px 10px rgba(217,119,6,.3);
    }
    .btn-modal-amber:hover { opacity: .88; }

    .btn-modal-red {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        background: #dc2626; /* Warna Solid */
        color: #fff;
        cursor: pointer;
        transition: opacity .15s;
        box-shadow: 0 4px 10px rgba(220,38,38,.3);
    }
    .btn-modal-red:hover { opacity: .88; }

    /* ── Delete modal confirm ── */
    .delete-confirm-icon {
        width: 64px; height: 64px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        font-size: 26px;
        color: #dc2626;
    }
    .delete-confirm-text {
        text-align: center;
        font-size: 13px;
        color: #374151;
        line-height: 1.6;
    }
</style>

<div class="row">
<div class="col-md-12">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Master Ruangan
            </h1>
        </div>
        <button class="btn-add" data-toggle="modal" data-target="#modalTambahruangan">
            <i class="fas fa-plus" style="font-size:12px"></i>
            Tambah Ruangan
        </button>
    </div>

    {{-- Stat Card --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Ruangan</div>
            <div class="stat-value">{{ $data_ruangan->total() }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-door-open"></i>
        </div>
    </div>

    {{-- Search --}}
    <div class="search-wrap">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="liveSearchInput"
                class="search-input"
                placeholder="Ketik nama ruangan untuk mencari...">
        </div>
        <button class="btn-clear" id="resetSearch" title="Reset pencarian" style="display:none;">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <table id="ruanganTable">
            <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">No</th>
                    <th class="text-center">Nama Ruangan</th>
                    <th class="text-center">Lokasi</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody-user">
                @foreach ($data_ruangan as $index => $ruangan)
                <tr id="row-{{ $ruangan->id_ruangan }}">
                    <td class="text-center">{{ $data_ruangan->firstItem() + $index }}</td>

                    <td class="text-center" style="font-weight:500; color: var(--rs-purple);">
                        {{ $ruangan->nama_ruangan }}
                    </td>

                    <td class="text-center">
                        {{ $ruangan->lokasi }}
                    </td>

                    <td class="text-center">
                        <div class="action-buttons">
                            <button class="btn-icon btn-icon-edit btn-edit"
                                data-id_ruangan="{{ $ruangan->id_ruangan }}"
                                data-nama_ruangan="{{ $ruangan->nama_ruangan }}"
                                data-lokasi="{{ $ruangan->lokasi }}"
                                type="button" title="Edit ruangan">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger btn-hapus"
                                data-id_ruangan="{{ $ruangan->id_ruangan }}"
                                data-nama_ruangan="{{ $ruangan->nama_ruangan }}"
                                type="button" title="Hapus ruangan">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
        <span class="pagination-info">
            Menampilkan {{ $data_ruangan->firstItem() }} – {{ $data_ruangan->lastItem() }}
            dari {{ $data_ruangan->total() }} data
        </span>
        {{ $data_ruangan->appends(['lokasi' => $lokasi])->links('pagination::bootstrap-4') }}
    </div>

</div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('ruangan/data_ruangan') }}" method="POST">
                @csrf
                <div class="modal-header-main">
                    <h5 class="modal-title-custom">Tambah Ruangan</h5>
                    <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label-custom">Nama Ruangan</label>
                        <input type="text" class="form-control-custom" name="nama_ruangan" placeholder="Masukkan nama ruangan" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Lokasi</label>
                        <select class="form-control-custom" name="lokasi" required>
                            <option value="" disabled selected>Pilih Lokasi...</option>
                            <option value="Lt. 1">Lantai 1</option>
                            <option value="Lt. 2">Lantai 2</option>
                            <option value="Lt. 3">Lantai 3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-main">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditruangan" method="POST">
                @csrf
                <div class="modal-header-amber">
                    <h5 class="modal-title-custom">Edit Ruangan</h5>
                    <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label-custom">Nama Ruangan</label>
                        <input type="text" class="form-control-custom" id="edit_ruangan" name="nama_ruangan" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Lokasi</label>
                        <select class="form-control-custom" name="lokasi" id="edit_lokasi" required>
                            <option value="" disabled selected>Pilih Lokasi...</option>
                            <option value="Lt. 1">Lantai 1</option>
                            <option value="Lt. 2">Lantai 2</option>
                            <option value="Lt. 3">Lantai 3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" form="formEditruangan" class="btn-modal-amber">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapusruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header-red">
                <h5 class="modal-title-custom">Hapus Ruangan</h5>
                <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirm-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div class="delete-confirm-text">
                    Apakah Anda yakin ingin menghapus ruangan<br>
                    <strong id="hapus_nama_ruangan" style="color:#111827"></strong>?
                    <br><br>
                    <span style="color:var(--text-sub);font-size:11px">Tindakan ini tidak dapat dibatalkan.</span>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center" style="gap:8px">
                <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="btn-modal-red">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const baseUrl = "{{ url('') }}";

    const allData = @json($all_ruangan);
    const liveSearchInput = document.getElementById('liveSearchInput');
    const resetSearch = document.getElementById('resetSearch');
    const tableRows = document.querySelectorAll('#ruanganTable tbody tr');
    const tbody = document.getElementById('tbody-user');

    liveSearchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();

        const filtered = allData.filter(item => {
            return (
                (item.nama_ruangan ?? '').toLowerCase().includes(keyword) ||
                (item.lokasi ?? '').toLowerCase().includes(keyword)
            );
        });

        tbody.innerHTML = '';

        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>`;
            return;
        }

        filtered.forEach((item, index) => {
            tbody.innerHTML += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center" style="font-weight:500; color: var(--rs-purple);">
                        ${item.nama_ruangan}
                    </td>
                    <td class="text-center">
                        ${item.lokasi}
                    </td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <button class="btn-icon btn-icon-edit btn-edit"
                                data-id_ruangan="${item.id_ruangan}"
                                data-nama_ruangan="${item.nama_ruangan}"
                                data-lokasi="${item.lokasi}">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon btn-icon-danger btn-hapus"
                                data-id_ruangan="${item.id_ruangan}"
                                data-nama_ruangan="${item.nama_ruangan}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        resetSearch.style.display = keyword ? 'inline-flex' : 'none';
    });

    resetSearch.addEventListener('click', function () {
        liveSearchInput.value = '';
        location.reload(); 
    });

    document.getElementById('modalTambahruangan').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.querySelector('#modalTambahruangan button[type="submit"]').click();
        }
    });

    document.getElementById('tbody-user').addEventListener('click', function (e) {
        const editBtn = e.target.closest('.btn-edit');
        const hapusBtn = e.target.closest('.btn-hapus');

        if (editBtn) {
            document.getElementById('edit_ruangan').value = editBtn.dataset.nama_ruangan;
            document.getElementById('edit_lokasi').value = editBtn.dataset.lokasi;

            document.getElementById('formEditruangan').action =
                baseUrl + '/ruangan/data_ruangan/' + editBtn.dataset.id_ruangan + '/update';

            $('#modalEditruangan').modal('show');
        }

        if (hapusBtn) {
            document.getElementById('hapus_nama_ruangan').textContent =
                hapusBtn.dataset.nama_ruangan;

            document.getElementById('formHapus').action =
                baseUrl + '/ruangan/data_ruangan/' + hapusBtn.dataset.id_ruangan + '/delete';

            $('#modalHapusruangan').modal('show');
        }
    });
</script>
@endsection
