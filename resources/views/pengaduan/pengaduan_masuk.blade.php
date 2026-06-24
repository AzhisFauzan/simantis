@extends('layout.page')
@section('judul', 'Pengaduan Masuk')
@section('content')

<style>
    :root {
        --primary:        #4f46e5;
        --primary-hover:  #4338ca;
        --primary-soft:   #e0e7ff;
        --success:        #10b981;
        --success-soft:   #d1fae5;
        --warning:        #f59e0b;
        --warning-soft:   #fef3c7;
        --info:           #3b82f6;
        --info-soft:      #dbeafe;
        
        --surface:        #ffffff;
        --background:     #f8fafc;
        --border-light:   #e2e8f0;
        --border-focus:   #cbd5e1;
        --text-dark:      #0f172a;
        --text-muted:     #64748b;
        --text-light:     #94a3b8;

        --radius-md:      12px;
        --radius-lg:      16px;
        --transition:     all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { box-sizing: border-box; font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif; }

    .page-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px; flex-wrap: wrap; gap: 16px;
    }
    .page-title { font-size: 20px; font-weight: 700; color: var(--text-dark); margin: 0; letter-spacing: -0.02em; }
    .page-subtitle { font-size: 13px; font-weight: 500; color: var(--text-muted); margin-top: 4px; }

    .filter-bar { display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; }
    .filter-pill {
        padding: 8px 16px; border-radius: 30px; font-size: 13px; font-weight: 600;
        border: 1px solid var(--border-light); background: var(--surface); color: var(--text-muted);
        text-decoration: none; transition: var(--transition);
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .filter-pill.active, .filter-pill:hover {
        background: var(--text-dark); color: #fff; border-color: var(--text-dark);
        transform: translateY(-1px);
    }

    .pengaduan-card {
        background: var(--surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-light);
        margin-bottom: 16px;
        display: flex;
        flex-wrap: wrap;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        position: relative;
    }
    .pengaduan-card:hover { 
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.01);
        border-color: var(--border-focus);
    }

    .pengaduan-card::before {
        content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
        border-radius: 4px 0 0 4px;
    }
    .pengaduan-card.status-pending::before  { background: var(--warning); }
    .pengaduan-card.status-diproses::before { background: var(--info); }
    .pengaduan-card.status-selesai::before  { background: var(--success); }

    .card-body { 
        flex: 1; min-width: 280px; padding: 20px 24px; 
    }
    
    .card-actions { 
        min-width: 260px; padding: 20px 24px; 
        background: #f8fafc; border-left: 1px solid var(--border-light);
        display: flex; flex-direction: column; justify-content: center;
    }
    @media (max-width: 768px) {
        .card-actions { border-left: none; border-top: 1px solid var(--border-light); }
    }

    .label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-light); letter-spacing: 0.05em; margin-top: 12px; }
    .label:first-of-type { margin-top: 0; }
    .value { font-size: 14px; font-weight: 600; color: var(--text-dark); margin-top: 4px; display: flex; align-items: center; gap: 6px; }
    .desc  { font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-top: 4px; background: var(--background); padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-light); }
    .desc-tindakan { background: var(--success-soft); border-color: #a7f3d0; color: #065f46; }

    .badge-status {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;
        letter-spacing: 0.02em;
    }
    .badge-pending  { background: var(--warning-soft); color: #b45309; border: 1px solid #fde68a; }
    .badge-diproses { background: var(--info-soft); color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-selesai  { background: var(--success-soft); color: #047857; border: 1px solid #a7f3d0; }

    .form-update label { font-size: 12px; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 6px; }
    .form-update select, .form-update textarea {
        width: 100%; border: 1px solid var(--border-light); border-radius: 8px;
        padding: 10px 12px; font-size: 13px; color: var(--text-dark);
        background: var(--surface); margin-bottom: 12px;
        transition: var(--transition);
    }
    .form-update select:focus, .form-update textarea:focus {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-soft);
    }
    
    .btn-update {
        width: 100%; background: var(--primary); color: #fff;
        border: none; border-radius: 8px; padding: 10px 0;
        font-size: 13px; font-weight: 600; cursor: pointer; transition: var(--transition);
        display: flex; justify-content: center; align-items: center; gap: 8px;
    }
    .btn-update:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2); }
    .btn-update:disabled { background: var(--text-light); cursor: not-allowed; transform: none; box-shadow: none; }

    .empty-state {
        text-align: center; padding: 80px 20px;
        background: var(--surface); border-radius: var(--radius-lg); border: 2px dashed var(--border-light);
    }
    .empty-state i { font-size: 48px; color: var(--border-light); margin-bottom: 16px; }
    .empty-state p { color: var(--text-muted); font-size: 15px; font-weight: 500; }

    .tanggal { font-size: 12px; color: var(--text-muted); margin-top: 16px; display: flex; align-items: center; gap: 6px; }
</style>

<div class="page-header">
    <div>
        <div class="page-title"><i class="fas fa-bell me-2 text-warning"></i> Pengaduan Masuk</div>
        <div class="page-subtitle">Notifikasi pengaduan dari SIPITRS – pantau dan perbarui status tindakan</div>
    </div>
    <div class="badge-status badge-pending px-3 py-2 shadow-sm">
        <i class="fas fa-inbox me-2"></i> Total Pending: {{ $jumlahPending }}
    </div>
</div>

<div class="filter-bar">
    @foreach(['semua' => 'Semua', 'Pending' => 'Pending', 'Diproses' => 'Diproses', 'Selesai' => 'Selesai'] as $val => $label)
        <a href="{{ url('/pengaduan-masuk?status=' . $val) }}"
           class="filter-pill {{ $statusFilter === $val ? 'active' : '' }}">
             {{ $label }}
        </a>
    @endforeach
</div>

@if($session_sukses = session('sukses'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert" style="background: var(--success-soft); color: #065f46;">
        <i class="fas fa-check-circle me-2"></i>{{ $session_sukses }}
    </div>
@endif

@if($session_error = session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert" style="background: #fee2e2; color: #991b1b;">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ $session_error }}
    </div>
@endif

@forelse($pengaduan as $item)
@php
    $statusKey = strtolower(str_replace(' ', '', $item->status));
    $badgeClass = match($item->status) {
        'Pending'  => 'badge-pending',
        'Diproses' => 'badge-diproses',
        'Selesai'  => 'badge-selesai',
        default    => '',
    };
@endphp
<div class="pengaduan-card status-{{ $statusKey }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge-status {{ $badgeClass }}">{{ $item->status }}</span> 
            <span style="font-size: 12px; font-weight: 600; color: var(--text-light);">#{{ $item->id }}</span>
        </div>
        
        <div class="row mb-3">
            <div class="col-sm-6">
                <div class="label">Ruangan</div>
                <div class="value"><i class="fas fa-door-open text-primary opacity-75"></i> {{ $item->nama_ruangan }}</div>
            </div>
            @if(isset($item->kode_inventaris) && $item->kode_inventaris !== '-')
            <div class="col-sm-6 mt-3 mt-sm-0">
                <div class="label">Perangkat</div>
                <div class="value">
                    <i class="fas fa-desktop text-info opacity-75"></i> 
                    {{ $item->kategori_perangkat }} <span class="text-muted fw-normal">({{ $item->merek_perangkat }})</span>
                </div>
                <div style="font-size: 11px; margin-top: 4px; color: var(--text-muted);">ID: {{ $item->kode_inventaris }}</div>
            </div>
            @endif
        </div>

        <div class="label">Deskripsi Masalah</div>
        <div class="desc">{{ $item->deskripsi_masalah }}</div>
        
        @if($item->deskripsi_tindakan)
            <div class="label mt-3">Tindakan Teknisi</div>
            <div class="desc desc-tindakan"><i class="fas fa-comment-dots me-1 opacity-75"></i> {{ $item->deskripsi_tindakan }}</div>
        @endif
        
        <div class="tanggal">
            <i class="fas fa-clock opacity-50"></i>
            Masuk: {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y, H:i') }} WIB
        </div>
    </div>

    @if($item->status !== 'Selesai')
    <div class="card-actions">
        <form action="{{ url('/pengaduan-masuk/' . $item->id . '/update') }}" method="POST" class="form-update m-0">
            @csrf
            <label>Ubah Status</label>
            <select name="status" required class="status-select">
                <option value="">-- Pilih Status --</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
            </select>

            <label>Tindakan</label>
            <input type="text" name="tindakan">
            
            <label>Deskripsi Tindakan</label>
            <textarea name="deskripsi_tindakan" rows="2" placeholder="Ketikan deskripsi perbaikan di sini..."></textarea>
            
            <button type="submit" class="btn-update">
                <i class="fas fa-check-circle"></i> Simpan 
            </button>
        </form>
    </div>
    @endif
</div>
@empty
<div class="empty-state shadow-sm">
    <i class="fas fa-inbox"></i>
    <p class="m-0">Belum ada data pengaduan untuk filter ini.</p>
</div>
@endforelse

<div class="d-flex justify-content-center mt-4 mb-5">
    {{ $pengaduan->withQueryString()->links() }}
</div>

<script>
    document.querySelectorAll('.status-select').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            let id = this.getAttribute('data-id');
            let descMaint = this.getAttribute('data-desc');
            let descArea = document.getElementById('desc-' + id);
            
            if (this.value === 'Selesai') {
                descArea.value = descMaint;
                descArea.setAttribute('readonly', 'readonly');
                descArea.style.backgroundColor = 'var(--background)'; 
                descArea.style.color = 'var(--text-muted)';
                descArea.style.cursor = 'not-allowed';
                descArea.style.borderColor = 'var(--border-light)';
            } else {
                descArea.removeAttribute('readonly');
                descArea.style.backgroundColor = 'var(--surface)';
                descArea.style.color = 'var(--text-dark)';
                descArea.style.cursor = 'text';
            }
        });
    });
</script>

@endsection