@extends('layout.page')
@section("judul","Ruangan")
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    :root {
        /* Warna Khas RS Darmayu */
        --rs-purple:       #6b21a8; /* Ungu Utama */
        --rs-purple-hover: #581c87;
        --rs-purple-soft:  #f3e8ff;
        --rs-purple-mid:   #d8b4fe;

        --rs-green:        #16a34a; /* Hijau Utama */
        --rs-green-hover:  #15803d;
        --rs-green-soft:   #dcfce7;
    }

    .ruangan-wrapper {
        font-family: 'Inter', sans-serif;
        padding: 4px 2px;
    }

    .search-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .search-field {
        width: 100%;
        height: 42px;
        /* Padding FIXED & SIMETRIS */
        padding: 0 50px 0 45px !important;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        background: #fff;
        color: #1e293b;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
        outline: none;
    }

    .search-field:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107,33,168,0.1);
    }

    /* Icon search POSISI PERFECT */
    .search-icon-left {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
        z-index: 5;
        line-height: 1;
    }

    /* Clear button SIMETRIS & SMOOTH */
    .search-clear {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 50%;
        display: flex !important;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #64748b;
        font-size: 11px;
        font-weight: 300;
        transition: all 0.2s ease;
        opacity: 0;
        visibility: hidden;
        z-index: 5;
        line-height: 1;
    }

    /* Muncul smooth TANPA ganggu layout */
    .search-clear.show {
        opacity: 1;
        visibility: visible;
    }

    .search-clear:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: translateY(-50%) scale(1.1);
        border-color: #fca5a5;
    }

    /* SPAN placeholder SAME SIZE - tidak bergeser */
    #clearBtn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        display: block;
        pointer-events: none;
        z-index: 1;
    }

    .result-count {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 14px;
        font-weight: 500;
    }

    .result-count strong {
        color: var(--rs-purple);
        font-weight: 600;
    }

    .room-card-link {
        text-decoration: none;
        display: block;
    }

    .room-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow 0.18s, border-color 0.18s, transform 0.15s;
        cursor: pointer;
    }

    .room-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        border-color: var(--rs-purple-mid);
        transform: translateY(-1px);
    }

    .room-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--rs-purple-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .room-card-icon i {
        font-size: 16px;
        color: var(--rs-purple);
    }

    .room-card-name {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.3;
        flex: 1;
    }

    .room-card-arrow {
        color: #cbd5e1;
        font-size: 11px;
        flex-shrink: 0;
        transition: color 0.2s;
    }

    .room-card:hover .room-card-arrow {
        color: var(--rs-purple);
    }

    .alert-empty {
        background: var(--rs-purple-soft);
        border: 1px solid var(--rs-purple-mid);
        border-radius: 10px;
        padding: 16px 18px;
        color: var(--rs-purple-hover);
        font-size: 13.5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="ruangan-wrapper">
    @php
        $icons = [
            'fas fa-clipboard-list',
            'fas fa-id-card',
            'fas fa-pills',
            'fas fa-briefcase-medical',
            'fas fa-cash-register',
            'fas fa-money-bill-wave',
            'fas fa-user-md',
            'fas fa-flask',
            'fas fa-user-nurse',
            'fas fa-stethoscope',
            'fas fa-baby',
            'fas fa-user-md',
            'fas fa-brain',
            'fas fa-tooth',
            'fas fa-heartbeat',
            'fas fa-brain',
            'fas fa-eye',
            'fas fa-brain',
            'fas fa-female',
            'fas fa-bone',
            'fas fa-lungs',
            'fas fa-stethoscope',
            'fas fa-wheelchair',
            'fas fa-brain',
            'fas fa-head-side-mask',
            'fas fa-x-ray',
            'fas fa-clipboard-check',
            'fas fa-baby-carriage',
            'fas fa-procedures',
            'fas fa-hospital',
            'fas fa-utensils',
            'fas fa-heart-pulse',
            'fas fa-coins',
            'fas fa-hospital-user',
            'fas fa-file-invoice',
            'fas fa-hospital',
            'fas fa-boxes',
            'fas fa-hospital',
            'fas fa-hospital',
            'fas fa-procedures',
            'fas fa-cogs',
            'fas fa-baby',
            'fas fa-folder-open',
        ];
    @endphp

    <div class="search-wrapper">
        <i class="fas fa-search search-icon-left"></i>
        <input type="text" id="liveSearchInput" class="search-field" placeholder="Cari nama ruangan..." autocomplete="off">
        <div class="search-clear" id="clearBtn">
            {{-- <i class="fas fa-times"></i> --}}
        </div>
    </div>

    <div id="hasil-ruangan" class="row" style="margin: 0;">
        <div class="col-12 result-count" id="liveResultCount" style="display:none;">
            Menampilkan <strong id="countNum">0 hasil</strong> untuk "<span id="keywordText"></span>"
        </div>

        @foreach ($ruangan2 as $index => $ruang)
        <div class="col-xl-4 col-md-6 col-12 room-item" style="padding: 0 6px;" data-nama="{{ strtolower($ruang->nama_ruangan) }}">
            <a href="{{ url('perangkat/data_perangkat/' . $ruang->id) }}" class="room-card-link">
                <div class="room-card">
                    <div class="room-card-icon">
                        <i class="{{ $icons[$index % count($icons)] }}"></i>
                    </div>
                    <span class="room-card-name">{{ $ruang->nama_ruangan }}</span>
                    <span class="room-card-arrow"><i class="fas fa-chevron-right"></i></span>
                </div>
            </a>
        </div>
        @endforeach

        <div class="col-12" id="noDataAlert" style="display:none;">
            <div class="alert-empty">
                <i class="fas fa-search" style="font-size:16px; color: var(--rs-purple);"></i>
                Ruangan "<strong id="noDataKeyword"></strong>" tidak ditemukan.
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
    })();

    const inputSearch = document.getElementById('liveSearchInput');
    const clearBtn = document.getElementById('clearBtn');
    const roomItems = document.querySelectorAll('.room-item');
    const resultCountDiv = document.getElementById('liveResultCount');
    const countNum = document.getElementById('countNum');
    const keywordText = document.getElementById('keywordText');
    const noDataAlert = document.getElementById('noDataAlert');
    const noDataKeyword = document.getElementById('noDataKeyword');

    inputSearch.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        let foundCount = 0;

        if (keyword.length > 0) {
            clearBtn.classList.add('show');
            resultCountDiv.style.display = 'block';
            keywordText.innerText = keyword;
        } else {
            clearBtn.classList.remove('show');
            resultCountDiv.style.display = 'none';
        }

        roomItems.forEach(item => {
            const nama = item.getAttribute('data-nama');
            if (nama.includes(keyword)) {
                item.style.display = 'block';
                foundCount++;
            } else {
                item.style.display = 'none';
            }
        });

        countNum.innerText = foundCount + ' hasil';

        if (foundCount === 0 && keyword.length > 0) {
            noDataAlert.style.display = 'block';
            noDataKeyword.innerText = keyword;
        } else {
            noDataAlert.style.display = 'none';
        }
    });

    clearBtn.addEventListener('click', function() {
        inputSearch.value = '';
        inputSearch.focus();

        roomItems.forEach(item => item.style.display = 'block');
        clearBtn.classList.remove('show');
        resultCountDiv.style.display = 'none';
        noDataAlert.style.display = 'none';
    });
</script>

@endsection
