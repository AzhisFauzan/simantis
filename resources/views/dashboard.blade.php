@extends('layout.page')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        /* Warna Khas RS Darmayu - Flat Version */
        --rs-purple:       #7b2fbe; /* Purple solid */
        --rs-green:        #1db954; /* Green solid */
        --rs-blue:         #0284c7; /* Blue solid */
        --rs-amber:        #d97706; /* Amber solid */

        --bg:        #f8fafc;
        --surface:   #ffffff;
        --text-main: #0f172a;
        --text-sub:  #64748b;
        --border:    #e2e8f0;
    }

    .dashboard-page {
        font-family: 'DM Sans', sans-serif;
        padding-top: 20px; /* Jarak atas karena header dihapus */
        padding-bottom: 40px;
    }

    /* ── Stat Cards (Modern Flat Design) ── */
    .stat-card {
        border-radius: 16px;
        padding: 24px 24px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        /* Box shadow tipis untuk kesan elevate */
        box-shadow: 0 4px 12px rgba(0,0,0,.05);
        height: 100%;
        transition: transform .3s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow .3s;
        border: none; /* Hapus border SB Admin default */
    }

    /* Solid Background Colors (No Gradient) */
    .stat-card-purple { background-color: var(--rs-purple); }
    .stat-card-green  { background-color: var(--rs-green); }
    .stat-card-amber  { background-color: var(--rs-amber); }
    .stat-card-blue   { background-color: var(--rs-blue); }

    /* Decorative Circles (Translucent Flat) */
    .stat-card::after {
        content: '';
        position: absolute;
        right: -24px; bottom: -24px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.1); /* Flat Translucent White */
        transition: transform .4s;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        right: 50px; bottom: -40px;
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,.06); /* Flat Translucent White */
        transition: transform .4s;
    }

    /* Hover Effect */
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,.1);
    }
    .stat-card:hover::after { transform: scale(1.05); }
    .stat-card:hover::before { transform: scale(1.1); }

    .stat-content {
        position: relative;
        z-index: 2;
    }
    .stat-label {
        font-size: 13px;
        font-weight: 700;
        opacity: .85;
        text-transform: uppercase;
        letter-spacing: .8px;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 38px;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -1px;
    }
    .stat-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,.15); /* Flat background icon */
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        position: relative;
        z-index: 2;
    }

    /* ── Animations ── */
    .card-animate {
        opacity: 0;
        transform: translateY(20px);
    }
    .card-animate.visible {
        animation: dbCardIn .5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }
    @keyframes dbCardIn {
        to { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive Mobile ── */
    @media screen and (max-width: 768px) {
        .stat-card { padding: 20px; }
        .stat-value { font-size: 32px; }
        .stat-icon { width: 48px; height: 48px; font-size: 20px; }
        .dashboard-page { padding-top: 10px; }
    }
</style>

<div class="dashboard-page container-fluid px-0">

    {{-- Query Data PHP --}}
    @php
        $userCount = DB::table('users')->count();
        $perangkatCount = DB::table('perangkat')->count();
        $maintenanceCount = DB::table('maintenance')->distinct()->count('id_ruangan');
        $ruanganCount = DB::table('ruangan')->count();
    @endphp

    {{-- Grid Stats --}}
    <div class="row">

        {{-- Card: Users --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-purple card-animate">
                <div class="stat-content">
                    <div class="stat-label">Total Pengguna</div>
                    <div class="stat-value">{{ $userCount }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        {{-- Card: Perangkat --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-green card-animate">
                <div class="stat-content">
                    <div class="stat-label">Total Perangkat</div>
                    <div class="stat-value">{{ $perangkatCount }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-laptop-medical"></i>
                </div>
            </div>
        </div>

        {{-- Card: Maintenance --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-amber card-animate">
                <div class="stat-content">
                    <div class="stat-label">Ruang di-Maintenance</div>
                    <div class="stat-value">{{ $maintenanceCount }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
        </div>

        {{-- Card: Ruangan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card stat-card-blue card-animate">
                <div class="stat-content">
                    <div class="stat-label">Total Ruangan</div>
                    <div class="stat-value">{{ $ruanganCount }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-hospital-user"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Animasi staggered (muncul berurutan) untuk cards
    const cards = document.querySelectorAll('.card-animate');
    cards.forEach((el, index) => {
        setTimeout(() => {
            el.classList.add('visible');
        }, index * 80); // jeda 80ms antar card agar lebih smooth
    });
});
</script>
@endsection
