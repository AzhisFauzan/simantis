@extends('layout.page')
@section("judul","Data Kategori")
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

    /* ── Page Header ── */
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
    .page-subtitle {
        font-size: 0.85rem;
        color: var(--text-sub);
        margin-top: 4px;
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

    /* ── Stat Card (Disesuaikan dengan Ungu RS) ── */
    .stat-card {
        background: var(--rs-purple); /* Solid Color */
        border-radius: 12px;
        padding: 16px 20px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(107,33,168,.25);
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
    }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 100px;
    }
    .table-card .card-body { padding: 0; }

    #kategoriTable { margin: 0; border-collapse: collapse; width: 100%; }

    /* Header Tabel menggunakan Ungu RS Solid */
    #kategoriTable thead tr {
        background: var(--rs-purple);
    }
    #kategoriTable thead th {
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 14px 14px;
        border: none;
        white-space: nowrap;
    }
    #kategoriTable tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.12s;
    }
    #kategoriTable tbody tr:last-child { border-bottom: none; }
    #kategoriTable tbody tr:hover { background: var(--slate); }
    #kategoriTable tbody td {
        font-size: 0.85rem;
        color: var(--text-main);
        padding: 12px 14px;
        border: none;
        vertical-align: middle;
    }

    /* ── Action Buttons ── */
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
        transition: all 0.15s;
        font-size: 13px;
    }
    .action-btn.delete { color: #dc2626; }
    .action-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }

    /* ── Modal Base (Disesuaikan dengan Ungu & Hijau Solid) ── */
    .modal-content {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
    }
    .modal-footer { border-top: 1px solid var(--border); padding: 12px 20px; }
    .modal-body   { padding: 20px; }

    .modal-header-add {
        background: var(--rs-purple); /* Solid Color */
        padding: 16px 20px;
    }
    .modal-header-add .modal-title,
    .modal-header-add .close { color: #fff; opacity: 1; }

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

    /* ── Buttons ── */
    .btn-primary-custom {
        background: var(--rs-green); /* Solid Color */
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

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 8px 18px;
        font-size: 0.85rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
    }
    .btn-secondary-custom:hover { background: #e2e8f0; }

    /* Empty state icon for purple theme */
    .empty-icon {
        width: 56px; height: 56px;
        background: var(--rs-purple-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 22px;
        color: var(--rs-purple-mid);
    }
</style>

<div class="page-wrapper">
<div class="row">
<div class="col-md-12 mb-3">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Master Kategori Perangkat
            </h1>
        </div>
        <button class="btn-add" data-toggle="modal" data-target="#modalKategori">
            <i class="fas fa-plus" style="font-size:11px;"></i> Tambah Kategori
        </button>
    </div>

    {{-- Stat Card --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Kategori</div>
            <div class="stat-value" id="stat-total">{{ $data_kategori->count() }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-layer-group"></i>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="card-body">
            <table class="table table-sm" id="kategoriTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;">No</th>
                        <th class="text-center">Nama Kategori</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-user">
                    @forelse ($data_kategori as $kategori)
                    <tr id="row-{{ $kategori->id_kategori }}">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center" style="font-weight:500; color: var(--rs-purple);">{{ $kategori->nama_kategori }}</td>
                        <td class="text-center">
                            <button class="action-btn delete btn-delete" data-id="{{ $kategori->id_kategori }}" type="button" title="Hapus kategori">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">
                            <div class="text-center p-4" style="color: var(--text-sub);">
                                <div class="empty-icon"><i class="fas fa-layer-group"></i></div>
                                Belum ada kategori perangkat.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>
</div>

{{-- Modal Tambah Kategori --}}
<div class="modal fade" id="modalKategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-add">
                <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formKategori">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorKat" class="alert alert-danger d-none" style="border-radius:8px; font-size:13px;"></div>
                    <div class="form-group mb-0">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Contoh: PC, Laptop, Printer...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal">Batal</button>
                    <button class="btn-primary-custom" type="button" id="saveKategori">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    $('#saveKategori').click(function(){
        if($('#nama_kategori').val() == ''){
            $('#alertErrorKat').removeClass('d-none').text('Nama Kategori wajib diisi!');
            return;
        }
        $('#alertErrorKat').addClass('d-none');

        $.ajax({
            url: "{{ url('/kategori/store') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                nama_kategori: $('#nama_kategori').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    // Menghapus baris "Belum ada kategori" jika ini data pertama
                    if($('#kategoriTable tbody tr td').length == 1) {
                        $('#kategoriTable tbody').empty();
                    }

                    let rowCount = $('#kategoriTable tbody tr').length + 1;

                    // Ditambahkan class text-center pada data hasil append AJAX
                    $('#kategoriTable tbody').append(`
                        <tr id="row-${response.id_kategori}">
                            <td class="text-center">${rowCount}</td>
                            <td class="text-center" style="font-weight:500; color: var(--rs-purple);">${response.nama_kategori}</td>
                            <td class="text-center">
                                <button class="action-btn delete btn-delete" data-id="${response.id_kategori}" type="button" title="Hapus kategori">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);

                    $('#formKategori')[0].reset();
                    $('#modalKategori').modal('hide');
                    $('#stat-total').text(parseInt($('#stat-total').text()) + 1);
                }
            }
        });
    });

    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        if(!confirm('Yakin hapus kategori ini?')) return;

        $.ajax({
            url: "{{ url('/kategori') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();
                    $('#kategoriTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                    $('#stat-total').text(parseInt($('#stat-total').text()) - 1);
                }
            }
        });
    });

    $('#modalKategori').on('hidden.bs.modal', function(){
        $('#alertErrorKat').addClass('d-none').text('');
        $('#formKategori')[0].reset();
    });

});
</script>
@endsection
