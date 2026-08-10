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
        --radius:    8px;
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
        font-size: 0.75rem;
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
        font-size: 0.75rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-add:hover { background: var(--rs-green-hover); color: #fff; }

    /* ── Stat Card (Disesuaikan dengan Ungu RS) ── */
    .stat-card {
        background: var(--rs-purple); /* Solid Color */
        border-radius: 8px;
        padding: 12px 16px;
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
        font-size: 10.5px;
        font-weight: 600;
        opacity: .8;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
    }
    .stat-icon {
        width: 40px; height: 40px;
        background: rgba(255,255,255,.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        position: relative;
        z-index: 1;
    }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
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
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 10px 10px;
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
        font-size: 0.75rem;
        color: var(--text-main);
        padding: 8px 10px;
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
        font-size: 11.5px;
    }
    .action-btn.delete { color: #dc2626; }
    .action-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }

    /* ── Modal Base ── */
    .modal-content {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        font-family: 'DM Sans', sans-serif;
        box-shadow: 0 20px 60px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.06);
    }
    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 10px 16px;
        display: flex;
        justify-content: flex-end;
        gap: 6px;
    }
    .modal-body { padding: 16px; }

    .modal-header-add {
        background: var(--rs-purple);
        padding: 10px 16px;
    }
    .modal-header-add .modal-title {
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: -.01em;
    }
    .modal-header-add .close {
        color: #fff;
        opacity: .7;
        font-size: 18px;
        padding: 0;
        margin: 0;
        line-height: 1;
    }
    .modal-header-add .close:hover { opacity: 1; }

    .modal-body label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }
    .modal-body .form-control {
        border-radius: 9px;
        border: 1.5px solid var(--border);
        font-size: 12.5px;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-main);
        padding: 8px 12px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .modal-body .form-control:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107,33,168,0.1);
    }

    /* ── Buttons ── */
    .btn-primary-custom {
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: 9px;
        padding: 7px 18px;
        font-size: 11.5px;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.15s, box-shadow 0.15s;
        box-shadow: 0 3px 10px rgba(22, 163, 74, .25);
    }
    .btn-primary-custom:hover { background: var(--rs-green-hover); color: #fff; }

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: 7px 16px;
        font-size: 11.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background .15s;
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

    /* Animasi Pop Spin untuk Icon Modal Success */
    @keyframes pop-spin {
        0% { transform: scale(0.5) rotate(-90deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(10deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    .animate-pop-spin {
        animation: pop-spin 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
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
    <div class="modal-dialog modal-sm" style="margin-top: 80px;">
        <div class="modal-content">
            <div class="modal-header modal-header-add">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formKategori">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorKat" class="alert alert-danger d-none" style="border-radius:8px; font-size:12px; padding: 8px 12px;"></div>
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

{{-- Modal Success (Centang / Hapus) --}}
<div class="modal fade" id="modalSuccess" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; text-align: center; padding: 20px;">
            <div class="modal-body">
                <div id="successIconContainer" style="width: 64px; height: 64px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i id="successIcon" class="fas fa-check" style="font-size: 32px; color: #16a34a;"></i>
                </div>
                <h5 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Berhasil!</h5>
                <p id="successMsg" style="font-size: 13px; color: #64748b; margin-bottom: 10px;">Data berhasil disimpan.</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="modalDeleteKategori" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; text-align: center; padding: 20px;">
            <div class="modal-body">
                <div style="width: 64px; height: 64px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-trash" style="font-size: 28px; color: #dc2626;"></i>
                </div>
                <h5 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Hapus Kategori?</h5>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Data yang dihapus tidak bisa dikembalikan.</p>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn-secondary-custom" data-dismiss="modal" style="flex: 1; border:none; background:#f1f5f9;">Batal</button>
                    <button type="button" id="confirmDeleteBtn" style="flex: 1; padding: 9px 16px; font-size: 11.5px; font-weight: 700; border: none; border-radius: 9px; background: #dc2626; color: #fff; cursor: pointer; transition: background .15s; box-shadow: 0 4px 10px rgba(220, 38, 38, .3);">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    function showSuccessModal(message, type = 'success') {
        $('#successMsg').text(message);
        
        let iconContainer = $('#successIconContainer');
        let icon = $('#successIcon');
        
        iconContainer.removeClass('animate-pop-spin');
        void iconContainer[0].offsetWidth; 
        iconContainer.addClass('animate-pop-spin');

        if(type === 'danger') {
            iconContainer.css('background', '#fee2e2'); 
            icon.attr('class', 'fas fa-trash').css('color', '#dc2626'); 
        } else {
            iconContainer.css('background', '#dcfce7'); 
            icon.attr('class', 'fas fa-check').css('color', '#16a34a'); 
        }

        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');

        setTimeout(function() {
            $('#modalSuccess').modal('show');
            setTimeout(function() {
                $('#modalSuccess').modal('hide');
            }, 1500);
        }, 100);
    }

    $('#modalSuccess').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });

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
                    showSuccessModal('Kategori berhasil ditambahkan');
                }
            }
        });
    });

    let idToDelete = null;
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        idToDelete = $(this).data('id');
        $('#modalDeleteKategori').modal('show');
    });

    $('#confirmDeleteBtn').click(function(){
        if(!idToDelete) return;
        $.ajax({
            url: "{{ url('/kategori') }}/" + idToDelete + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#modalDeleteKategori').modal('hide');
                    $('#row-' + idToDelete).remove();
                    $('#kategoriTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                    $('#stat-total').text(parseInt($('#stat-total').text()) - 1);
                    showSuccessModal('Kategori berhasil dihapus', 'danger');
                    idToDelete = null;
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
