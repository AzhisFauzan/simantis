@extends('layout.page')
@section("judul","Riwayat Maintenance")
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        --rs-purple:       #6b21a8; 
        --rs-purple-hover: #581c87;
        --rs-purple-soft:  #f3e8ff;
        --rs-purple-mid:   #d8b4fe;
        --rs-green:        #16a34a; 
        --rs-green-hover:  #15803d;
        --rs-green-soft:   #dcfce7;
        --slate:     #f8fafc;
        --border:    #cbd5e1;
        --text-main: #0f172a;
        --text-sub:  #475569;
    }

    * { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 4px 0;
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

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: var(--text-main);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none !important;
        transition: all .15s;
    }
    .btn-kembali:hover {
        background: var(--slate);
        border-color: var(--rs-purple-mid);
        color: var(--rs-purple);
    }

    .filter-wrapper {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
    }
    .filter-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 10px;
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
        min-width: 240px;
        cursor: pointer;
    }
    .select-kategori:focus { border-color: var(--rs-purple); }

    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 1px 8px rgba(0,0,0,.03);
    }

    #tabelRiwayat {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    #tabelRiwayat thead tr { background: var(--rs-purple); }
    #tabelRiwayat thead th {
        padding: 14px 16px;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .6px;
        border: none;
        text-align: left;
    }
    #tabelRiwayat thead th.text-center { text-align: center; }

    #tabelRiwayat tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .12s;
    }
    #tabelRiwayat tbody tr:last-child { border-bottom: none; }
    #tabelRiwayat tbody tr:hover { background: var(--slate); }

    #tabelRiwayat td {
        padding: 14px 16px;
        vertical-align: middle;
        color: var(--text-main);
    }

    .room-name-text { font-weight: 700; color: var(--rs-purple); }

    .badge-kategori {
        display: inline-block;
        background: var(--rs-purple-soft);
        color: var(--rs-purple);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid var(--rs-purple-mid);
    }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: 1px solid transparent;
        background: transparent;
        cursor: pointer;
        transition: all .15s;
        font-size: 13px;
        color: var(--rs-purple);
    }
    .btn-icon:hover { background: var(--rs-purple-soft); border-color: var(--rs-purple-mid); }

    .modal-content { border-radius: 12px; border: 1px solid var(--border); overflow: hidden; }
    .mhead {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: var(--rs-purple);
    }
    .mhead .modal-title { font-size: 15px; font-weight: 700; color: #fff; margin: 0; }
    .mhead .close { color: #fff; opacity: .85; border:none; background:none; font-size: 20px; cursor:pointer; }

    .modal-body { padding: 20px 24px; }
    .modal-footer { border-top: 1px solid var(--slate); padding: 14px 24px; background: #fff; }

    .detail-list { display: flex; flex-direction: column; gap: 10px; }
    .detail-item {
        padding: 12px 14px;
        background: var(--slate);
        border-radius: 8px;
        border: 1px solid var(--border);
    }
    .detail-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--text-sub);
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }
    .detail-value { font-size: 13px; font-weight: 700; color: var(--text-main); }
    .detail-value-desc {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-main);
        line-height: 1.5;
        margin-top: 6px;
        background: #fff;
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    .btn-tutup-detail {
        padding: 8px 20px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        border-radius: 6px;
        background: #475569;
        color: #fff;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-tutup-detail:hover { background: #334155; }

    .empty-state { text-align: center; padding: 50px 20px; color: var(--text-sub); }
</style>

<div class="row">
<div class="col-md-12 mb-3">

    <div class="page-header">
        <h1 class="page-title">Riwayat Maintenance</h1>
        <a href="{{ url('maintenance/maintenance') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:8px; font-size:13px; font-weight:600; background:var(--rs-green-soft); color:var(--rs-green-hover); border:1px solid #bbf7d0; padding: 12px 16px;">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" style="padding-top: 8px; border:none; background:none; color:var(--rs-green-hover);"><span>&times;</span></button>
        </div>
    @endif

    <div class="filter-wrapper">
        <span class="filter-label">Filter Berdasarkan Kategori</span>
        <select id="filterKategoriRiwayat" class="select-kategori">
            <option value="all">Semua Kategori</option>
            @foreach($kategoriPerangkat as $namaKategori => $items)
                @php $kat = $items->first(); @endphp
                <option value="{{ $kat->id_kategori }}">{{ $namaKategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table id="tabelRiwayat">
                <thead>
                    <tr>
                        <th class="text-center" style="width:60px">No</th>
                        <th>Ruangan</th>
                        <th>Perangkat</th>
                        <th>Sumber</th> 
                        <th>Tanggal Selesai</th>
                        <th>Teknisi</th>
                        <th>Deskripsi Pekerjaan</th>
                        <th class="text-center" style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $i => $item)
                    <tr class="riwayat-row" data-kategori="{{ $item->id_kategori }}">
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="room-name-text">{{ $item->nama_ruangan }}</td>
                        <td>
                            <span class="badge-kategori">{{ $item->kategori }}</span>
                        </td>
                        <td>
                            {!! $item->sumber_html !!} 
                        </td>
                        <td style="font-weight: 500;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i') }}</td>
                        <td style="font-weight: 600;">{{ $item->nama_teknisi ?? '-' }}</td>
                        <td style="color: var(--text-sub); font-size: 12px;">
                            {!! Str::limit(strip_tags($item->deskripsi), 50) !!}
                        </td>
                        <td class="text-center">
                            <button class="btn-icon btn-detail-riwayat"
                                data-id="{{ $item->id_maintenance }}"
                                data-toggle="modal"
                                data-target="#modalDetailRiwayat"
                                title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-inbox mb-3" style="font-size:32px; color: var(--border);"></i>
                                <p style="margin:0; font-size:14px; font-weight:700; color: var(--text-main);">Belum ada riwayat maintenance.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="empty-state d-none" id="pesanKosongRiwayat">
            <i class="fas fa-search mb-3" style="font-size:32px; color: var(--border);"></i>
            <p style="margin:0; font-size:14px; font-weight:700; color: var(--text-main);">Tidak ada riwayat ditemukan.</p>
        </div>
    </div>

</div>
</div>

<div class="modal fade" id="modalDetailRiwayat" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="mhead">
                <h5 class="modal-title">Informasi Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="riwayat-loading" class="text-center py-4">
                    <div class="spinner-border" style="color:var(--rs-purple); width:28px;height:28px;border-width:2px;" role="status"></div>
                    <p class="mt-2 text-muted" style="font-size:13px;font-weight:600;">Memuat data...</p>
                </div>

                <div id="riwayat-content" style="display:none;">
                    <div class="detail-list">
                        <div class="detail-item">
                            <div class="detail-label">Ruangan</div>
                            <div class="detail-value" id="r-ruangan">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Waktu Selesai</div>
                            <div class="detail-value" id="r-tanggal">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Dikerjakan Oleh</div>
                            <div class="detail-value" id="r-teknisi">-</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Kategori Perangkat</div>
                            <div class="detail-value" id="r-kategori" style="margin-top:6px;">-</div>
                        </div>
                        <div class="detail-item" style="background:transparent; border:none; padding:0;">
                            <div class="detail-label">Deskripsi Laporan</div>
                            <div class="detail-value-desc" id="r-deskripsi">-</div>
                        </div>
                    </div>
                </div>

                <div id="riwayat-error" class="alert alert-danger d-none" style="font-size:13px; font-weight:600; border-radius:8px;">
                    Gagal memuat data. Silakan coba lagi.
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" class="btn-tutup-detail" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#filterKategoriRiwayat').on('change', function(){
    var kategori = $(this).val();
    var ada = false;

    $('.riwayat-row').each(function(){
        var itemKategori = $(this).data('kategori').toString().split(',');
        var match = (kategori === 'all' || itemKategori.includes(kategori));
        $(this).toggle(match);
        if(match) ada = true;
    });

    $('#tabelRiwayat').toggle(ada);
    $('#pesanKosongRiwayat').toggleClass('d-none', ada);
});

$(document).on('click', '.btn-detail-riwayat', function(){
    var id = $(this).data('id');
    $('#riwayat-loading').show();
    $('#riwayat-content').hide();
    $('#riwayat-error').addClass('d-none');

    $.ajax({
        url: "{{ url('maintenance/detail-riwayat') }}/" + id, 
        method: 'GET',
        success: function(data){
            $('#r-ruangan').text(data.nama_ruangan ?? '-');
            $('#r-tanggal').text(data.tanggal      ?? '-');
            $('#r-teknisi').text(data.nama_teknisi  ?? '-');
            
            $('#r-deskripsi').html(data.deskripsi   ?? 'Tidak ada catatan.');

            var katHtml = '';
            if(data.kategoris && data.kategoris.length > 0){
                $.each(data.kategoris, function(i, k){
                    katHtml += '<span class="badge-kategori" style="margin: 0 4px 4px 0;">' + k.nama_kategori + '</span>';
                });
            } else { katHtml = '-'; }
            $('#r-kategori').html(katHtml);

            $('#riwayat-loading').hide();
            $('#riwayat-content').show();
        },
        error: function(){
            $('#riwayat-loading').hide();
            $('#riwayat-error').removeClass('d-none');
        }
    });
});
</script>
@endsection