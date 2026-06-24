@extends('layout.page')
@section("judul","Data User")
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
        --rs-green-mid:    #86efac;

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
        margin-bottom: 24px;
        padding: 4px 0;
    }
    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.3px;
        margin: 0;
    }

    .btn-add-user {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--rs-green);
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
    .btn-add-user:hover { background: var(--rs-green-hover); transform: translateY(-1px); color: #fff; }

    /* ── Stats ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    .stat-card {
        border-radius: 12px;
        padding: 16px 18px;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    /* Warna Solid */
    .stat-card-total    { background: var(--rs-purple); }
    .stat-card-admin    { background: #7c3aed; } /* Solid ungu agak terang */
    .stat-card-teknisi  { background: var(--rs-green); }

    .stat-card::after {
        content: '';
        position: absolute;
        right: -16px;
        bottom: -16px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,.12);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: 16px;
        bottom: -28px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
    }
    .stat-label {
        font-size: 11px;
        font-weight: 600;
        opacity: .9;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 6px;
    }
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
    }
    .stat-icon {
        position: absolute;
        right: 18px;
        top: 16px;
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,.2);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 100px;
        box-shadow: 0 1px 8px rgba(0,0,0,.04);
    }
    .table-card .card-body { padding: 0; }

    #userTable { margin: 0; border-collapse: collapse; width: 100%; }

    #userTable thead tr {
        background: var(--rs-purple);
    }
    #userTable thead th {
        color: #fff;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 14px 14px;
        border: none;
        white-space: nowrap;
        text-align: left; /* Kembalikan default rata kiri */
    }
    #userTable thead th:first-child { text-align: center; width: 60px; }
    #userTable thead th:last-child  { text-align: center; width: 100px; }

    #userTable tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.12s;
    }
    #userTable tbody tr:last-child { border-bottom: none; }
    #userTable tbody tr:hover { background: var(--slate); }
    #userTable tbody td {
        font-size: 0.85rem;
        color: var(--text-main);
        padding: 12px 14px;
        border: none;
        vertical-align: middle;
        text-align: left; /* Kembalikan default rata kiri */
    }
    #userTable tbody td:first-child { text-align: center; }
    #userTable tbody td:last-child  { text-align: center; }

    /* ── Avatar User Cell ── */
    .user-cell { display: flex; align-items: center; gap: 11px; text-align: left; }
    .avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .avatar-admin   { background: var(--rs-purple); color: #fff; }
    .avatar-teknisi { background: var(--rs-green); color: #fff; }

    .user-name { font-weight: 600; font-size: 13px; color: var(--text-main); }

    /* ── Badge ── */
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-admin   { background: var(--rs-purple-soft); color: var(--rs-purple); }
    .badge-teknisi { background: var(--rs-green-soft); color: var(--rs-green-hover); }

    .badge-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .badge-admin   .badge-dot { background: var(--rs-purple); }
    .badge-teknisi .badge-dot { background: var(--rs-green); }

    /* ── Action buttons ── */
    .action-buttons { display: inline-flex; gap: 5px; justify-content: center; }
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
    .action-btn.edit { color: #d97706; }
    .action-btn.edit:hover { background: #fef3c7; border-color: #fde68a; }
    .action-btn.delete { color: #dc2626; }
    .action-btn.delete:hover { background: #fef2f2; border-color: #fecaca; }

    /* ── Modal ── */
    .modal-content { border-radius: 14px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,.12); }

    /* Header modal solid */
    .modal-header-custom {
        background: var(--rs-purple);
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title-custom { font-size: 15px; font-weight: 700; color: #fff; margin: 0; }
    .modal-close-btn {
        width: 28px; height: 28px;
        background: rgba(255,255,255,.2);
        border: none; border-radius: 50%;
        color: #fff; font-size: 18px; line-height: 1;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .modal-close-btn:hover { background: rgba(255,255,255,.35); }
    .modal-body    { padding: 22px 24px; }
    .modal-footer  { border-top: 0.5px solid #f0f0f0; padding: 14px 24px; }

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
        border: 1px solid var(--border);
        border-radius: 9px;
        background: transparent;
        color: var(--text-sub);
        cursor: pointer;
        transition: all .15s;
        font-weight: 500;
    }
    .btn-cancel:hover { background: var(--slate); color: var(--rs-purple); border-color: var(--rs-purple-mid); }

    .btn-save-modal {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        background: var(--rs-green);
        color: #fff;
        cursor: pointer;
        transition: background .15s;
        box-shadow: 0 4px 10px rgba(22, 163, 74, .3);
    }
    .btn-save-modal:hover { background: var(--rs-green-hover); }

    /* Tombol update modal solid (Oranye) */
    .btn-update-modal {
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 9px;
        background: #d97706;
        color: #fff;
        cursor: pointer;
        transition: opacity .15s;
        box-shadow: 0 4px 10px rgba(217,119,6,.3);
    }
    .btn-update-modal:hover { opacity: .88; }

    .alert-custom-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
        border-radius: 9px;
        padding: 10px 13px;
        font-size: 12px;
        margin-bottom: 16px;
        font-weight: 500;
    }
    .alert-success {
        background-color: var(--rs-green-soft);
        color: var(--rs-green-hover);
        border: 1px solid #bbf7d0;
        border-radius: var(--radius);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Header modal edit solid (Oranye) */
    .modal-header-edit {
        background: #d97706;
        border-radius: 14px 14px 0 0;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="row">
<div class="col-md-12">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Manajemen User
            </h1>
        </div>
        <button class="btn-add-user" data-toggle="modal" data-target="#modalUser">
            <i class="fas fa-plus" style="font-size:11px;"></i>
            Tambah User
        </button>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card stat-card-total">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-label">Total User</div>
            <div class="stat-value" id="stat-total">{{ $data_user->count() }}</div>
        </div>
        <div class="stat-card stat-card-admin">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-label">Admin</div>
            <div class="stat-value" id="stat-admin">{{ $data_user->where('role','admin')->count() }}</div>
        </div>
        <div class="stat-card stat-card-teknisi">
            <div class="stat-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-label">Teknisi</div>
            <div class="stat-value" id="stat-teknisi">{{ $data_user->where('role','teknisi')->count() }}</div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="card-body">
            <table class="table table-sm" id="userTable">
                <thead class="thead-user">
                    <tr>
                        <th class="text-center" style="width: 80px;">No</th>
                        <th>Pengguna</th>
                        <th>Role</th> <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-user">
                    @foreach ($data_user as $user)
                    <tr id="row-{{ $user->id }}">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="avatar avatar-{{ $user->role }}">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="user-name">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td> <span class="badge badge-{{ $user->role }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <button class="action-btn edit btn-edit"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-role="{{ $user->role }}"
                                    title="Edit user" type="button">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="action-btn delete btn-delete"
                                    data-id="{{ $user->id }}"
                                    title="Hapus user" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5 class="modal-title-custom">Tambah User Baru</h5>
                <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
            </div>
            <form id="formUser">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert-custom-danger" style="display:none"></div>
                    <div class="form-group">
                        <label class="form-label-custom">Nama</label>
                        <input type="text" name="name" id="name" class="form-control-custom" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Password</label>
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="Masukkan password" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Role</label>
                        <select name="role" id="role" class="form-control-custom">
                            <option value="">Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button class="btn-cancel" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn-save-modal" type="button" id="saveUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header-edit">
                <h5 class="modal-title-custom">Edit User</h5>
                <button type="button" class="modal-close-btn" data-dismiss="modal">×</button>
            </div>
            <form id="formEditUser">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorEdit" class="alert-custom-danger" style="display:none"></div>
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label class="form-label-custom">Nama</label>
                        <input type="text" id="edit_name" class="form-control-custom" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom" style="display:flex; justify-content:space-between;">
                            Password
                            <span style="font-weight:400;color:var(--text-sub);text-transform:none">(kosongkan jika tidak diubah)</span>
                        </label>
                        <input type="password" id="edit_password" class="form-control-custom" placeholder="Password baru (opsional)" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Role</label>
                        <select id="edit_role" class="form-control-custom">
                            <option value="">Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button class="btn-cancel" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn-update-modal" type="button" id="updateUser">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStats() {
    var rows = $('#userTable tbody tr');
    var total = rows.length;
    var admin = rows.filter(function() {
        return $(this).find('.badge-admin').length > 0;
    }).length;
    var teknisi = rows.filter(function() {
        return $(this).find('.badge-teknisi').length > 0;
    }).length;
    $('#stat-total').text(total);
    $('#stat-admin').text(admin);
    $('#stat-teknisi').text(teknisi);
}

$(document).ready(function(){

    // ===================== TAMBAH USER =====================
    $('#saveUser').click(function(){
        var name = $('#name').val().trim();
        var pass = $('#password').val().trim();
        var role = $('#role').val();

        if(name == '' || pass == '' || role == ''){
            $('#alertError').show().text('Semua field wajib diisi');
            return;
        }
        $('#alertError').hide();

        $.ajax({
            url: "{{ url('/user/data_user') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                name: name,
                password: pass,
                role: role
            },
            success: function(response){
                if(response.status == 'success'){
                    var rowCount = $('#userTable tbody tr').length + 1;
                    $('#userTable tbody').append(`
                        <tr id="row-${response.id}">
                            <td class="text-center">${rowCount}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar avatar-${response.role}">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="user-name">${response.name}</div>
                                </div>
                            </td>
                            <td> <span class="badge badge-${response.role}">
                                    <span class="badge-dot"></span>
                                    ${response.role.charAt(0).toUpperCase() + response.role.slice(1)}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="action-btn edit btn-edit"
                                        data-id="${response.id}"
                                        data-name="${response.name}"
                                        data-role="${response.role}"
                                        title="Edit user" type="button">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="action-btn delete btn-delete"
                                        data-id="${response.id}"
                                        title="Hapus user" type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('#formUser')[0].reset();
                    $('#modalUser').modal('hide');
                    updateStats();
                    alert('Data berhasil disimpan');
                }
            },
            error: function(xhr){
                if(xhr.status == 422){
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val){
                        msg += '<i class="fas fa-exclamation-triangle"></i> ' + val[0] + '<br>';
                    });
                    $('#alertError').show().html(msg);
                } else {
                    alert('Terjadi kesalahan sistem.');
                }
            }
        });
    });

    // ===================== BUKA MODAL EDIT =====================
    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var id   = $(this).data('id');
        var name = $(this).data('name');
        var role = $(this).data('role');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_role').val(role);
        $('#edit_password').val('');
        $('#alertErrorEdit').hide().text('');
        $('#modalEditUser').modal('show');
    });

    // ===================== UPDATE USER =====================
    $('#updateUser').click(function(){
        if($('#edit_name').val() == '' || $('#edit_role').val() == ''){
            $('#alertErrorEdit').show().text('Nama dan Role wajib diisi');
            return;
        }
        $('#alertErrorEdit').hide();

        var id = $('#edit_id').val();

        $.ajax({
            url: "{{ url('/user/data_user') }}/" + id + "/update",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                name: $('#edit_name').val(),
                password: $('#edit_password').val(),
                role: $('#edit_role').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    var row = $('#row-' + id);

                    row.find('.user-cell').html(`
                        <div class="avatar avatar-${response.role}">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-name">${response.name}</div>
                    `);
                    row.find('td:nth-child(3)').html(`
                        <span class="badge badge-${response.role}">
                            <span class="badge-dot"></span>
                            ${response.role.charAt(0).toUpperCase() + response.role.slice(1)}
                        </span>
                    `);
                    row.find('.btn-edit')
                        .data('name', response.name)
                        .data('role', response.role);

                    $('#modalEditUser').modal('hide');
                    updateStats();
                    alert('Data berhasil diupdate');
                }
            },
            error: function(xhr){
                if(xhr.status == 422){
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val){
                        msg += '<i class="fas fa-exclamation-triangle"></i> ' + val[0] + '<br>';
                    });
                    $('#alertErrorEdit').show().html(msg);
                } else {
                    alert('Terjadi kesalahan sistem.');
                }
            }
        });
    });

    // ===================== HAPUS USER =====================
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        var id = $(this).data('id');

        if(!confirm('Yakin ingin menghapus user ini?')){ return; }

        $.ajax({
            url: "{{ url('/user/data_user') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();
                    $('#userTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                    updateStats();
                    alert('Data berhasil dihapus');
                }
            },
            error: function(){
                alert('Gagal menghapus data, silakan coba lagi');
            }
        });
    });

    // ===================== RESET MODAL =====================
    $('#modalUser').on('hidden.bs.modal', function(){
        $('#alertError').hide().text('');
        $('#formUser')[0].reset();
    });
    $('#modalEditUser').on('hidden.bs.modal', function(){
        $('#alertErrorEdit').hide().text('');
        $('#formEditUser')[0].reset();
    });

});
</script>
@endsection
