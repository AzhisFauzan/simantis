<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        --rs-purple:       #6b21a8;
        --rs-purple-hover: #581c87;
        --rs-green:        #1db954;
    }

    /* ── Dasar Sidebar ── */
    .navbar-nav.sidebar {
        background-color: var(--rs-purple) !important;
        font-family: 'DM Sans', sans-serif;
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh;
        width: 224px !important;
        z-index: 1000;
        overflow-x: hidden;
    }

    /* ── Toggled (Mini) Sidebar ── */
    .sidebar.toggled {
        width: 65px !important;
    }
    #accordionSidebar.toggled {
        overflow-x: hidden;
    }
    .sidebar.toggled .nav-item {
        width: 65px;
        text-align: center;
    }
    .sidebar.toggled .nav-item .nav-link {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 12px 0 !important;
        width: 65px;
    }
    .sidebar.toggled .nav-item .nav-link i {
        font-size: 1.1rem;
        width: auto;
        margin: 0 !important;
        float: none !important;
    }
    .sidebar.toggled .nav-item .nav-link span,
    .sidebar.toggled .sidebar-heading,
    .sidebar.toggled .sidebar-brand-text {
        display: none !important;
    }
    .sidebar.toggled .sidebar-brand {
        justify-content: center !important;
        padding: 10px 0 !important;
    }
    .sidebar.toggled .sidebar-brand-icon {
        margin: 0 !important;
        font-size: 1.2rem;
    }
    .sidebar.toggled hr.sidebar-divider {
        margin: 4px 10px !important;
    }

    /* ── Transisi Elemen ── */
    .sidebar .nav-link span,
    .sidebar .sidebar-heading,
    .sidebar .sidebar-brand-text {
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ── Pin Sidebar Button ── */
    .pin-sidebar {
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 0.8rem;
        cursor: pointer;
        padding: 0 4px;
        margin-left: auto;
        line-height: 1;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .sidebar.toggled #btn-pin-sidebar {
        display: none !important;
    }
    #btn-pin-sidebar.pinned {
        color: #fff !important;
    }
    .pin-sidebar:hover {
        color: #fff;
    }

    /* ── Brand Logo ── */
    .sidebar-brand-small {
        display: none;
        color: #fff;
    }
    .sidebar-brand-full {
        display: flex;
    }
    .sidebar.toggled .sidebar-brand-small {
        display: block !important;
    }
    .sidebar.toggled .sidebar-brand-full {
        display: none !important;
    }

    /* ── Styling Menu Item ── */
    .sidebar .nav-item .nav-link {
        color: rgba(255,255,255,0.8);
        padding: 12px 16px;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar .nav-item .nav-link i {
        color: rgba(255,255,255,0.7);
    }
    .sidebar .nav-item.active .nav-link {
        color: #fff;
        font-weight: 700;
        background-color: rgba(255, 255, 255, 0.15); /* Highlight menu aktif */
        border-left: 3px solid var(--rs-green); /* Aksen hijau RS di kiri */
    }
    .sidebar .nav-item.active .nav-link i {
        color: #fff;
    }
    .sidebar .nav-item .nav-link:hover {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.08);
    }
    .sidebar .nav-item .nav-link:hover i {
        color: #fff;
    }

    /* ── Sidebar Heading & Divider ── */
    .sidebar-heading {
        color: rgba(255,255,255,0.5) !important;
        font-size: 10.5px !important;
        letter-spacing: 0.8px;
        font-weight: 700;
        margin-top: 10px;
    }
    hr.sidebar-divider {
        border-top: 1px solid rgba(255,255,255,0.15);
    }

    /* ── Sub Menu Laporan ── */
    .sidebar .collapse-inner {
        background: var(--rs-purple-hover) !important; /* Ungu gelap untuk submenu */
        border-radius: 8px;
        margin: 0 10px;
    }
    .sidebar .collapse-inner .collapse-header {
        color: rgba(255,255,255,0.5);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sidebar .collapse-inner .collapse-item {
        color: rgba(255,255,255,0.8) !important;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }
    .sidebar .collapse-inner .collapse-item:hover,
    .sidebar .collapse-inner .collapse-item.active {
        background-color: rgba(255,255,255,0.15) !important;
        color: #fff !important;
        font-weight: 600;
    }
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- ── Logo & Brand ── --}}
    <div class="sidebar-brand d-flex align-items-center justify-content-center p-3">
        <div class="sidebar-brand-small">
            <a href="{{ url('/dashboard') }}" class="text-white">
                <i class="fas fa-bars" style="font-size:1.2rem;"></i>
            </a>
        </div>

        <div class="sidebar-brand-full d-flex align-items-center w-100">
            <a href="{{ url('/dashboard') }}" class="d-flex align-items-center text-white" style="text-decoration:none;">
                <div class="sidebar-brand-icon">
                    {{-- Tambahkan border-radius dan background putih jika logo gelap, atau biarkan transparan --}}
                    <img src="/img/logo.png" style="width:42px; height:42px; object-fit:contain; background:#fff; border-radius:8px; padding:2px;">
                </div>
                <div class="sidebar-brand-text mx-3" style="font-weight: 700; letter-spacing: 1px;">SIMANTIS</div>
            </a>
            <button id="btn-pin-sidebar" title="Tahan Sidebar" class="pin-sidebar ml-auto">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <hr class="sidebar-divider my-0">

    {{-- ── Menu Berdasarkan Role ── --}}
    @if(Auth::user()->role == 'admin')

        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- <li class="nav-item {{ request()->is('pengaduan-masuk') ? 'active' : '' }}">
            <a class="nav-link modern-link" href="{{ url('/pengaduan-masuk') }}">
                <i class="fas fa-bell"></i>
                <span>Pengaduan Masuk</span>
            </a>
        </li> --}}

        <hr class="sidebar-divider">

        <div class="sidebar-heading">DATA MASTER</div>

        <li class="nav-item {{ request()->is('user/data_user') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/user/data_user') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/kategori') }}">
                <i class="fas fa-fw fa-layer-group"></i>
                <span>Kategori Perangkat</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('ruangan/data_ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan/data_ruangan') }}">
                <i class="fas fa-fw fa-door-open"></i>
                <span>Data Ruangan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">INVENTARIS & MAINTENANCE</div>

        <li class="nav-item {{ request()->is('ruangan/ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan/ruangan') }}">
                <i class="fas fa-fw fa-desktop"></i>
                <span>Data Perangkat IT</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('maintenance/maintenance*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/maintenance/maintenance') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Tindakan Maintenance</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('laporan*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                aria-expanded="{{ request()->is('laporan*') ? 'true' : 'false' }}" aria-controls="collapseLaporan">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
            <div id="collapseLaporan" class="collapse {{ request()->is('laporan*') ? 'show' : '' }}" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner">
                    <h6 class="collapse-header">Pilih Laporan:</h6>
                    <a class="collapse-item {{ request()->is('laporan/inventaris*') ? 'active' : '' }}" href="{{ url('/laporan/inventaris') }}">
                        <i class="fas fa-fw fa-boxes mr-1"></i> Inventaris
                    </a>
                    <a class="collapse-item {{ request()->is('laporan/maintenance*') ? 'active' : '' }}" href="{{ url('/laporan/maintenance') }}">
                        <i class="fas fa-fw fa-tools mr-1"></i> Maintenance
                    </a>
                </div>
            </div>
        </li>

    @elseif(Auth::user()->role == 'teknisi')

        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">INVENTARIS & MAINTENANCE</div>

        <li class="nav-item {{ request()->is('ruangan/ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan/ruangan') }}">
                <i class="fas fa-fw fa-desktop"></i>
                <span>Data Perangkat IT</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('maintenance/maintenance*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/maintenance/maintenance') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Tindakan Maintenance</span>
            </a>
        </li>

    @endif

</ul>

<script>
    let sidebarReady = false;

    // Simpan state ke localStorage
    function saveSidebarState(isToggled) {
        localStorage.setItem('sidebarToggled', isToggled);
        localStorage.setItem('sidebarPinned', sidebarPinned);
    }

    // Load state dari localStorage
    function loadSidebarState() {
        const savedToggled = localStorage.getItem('sidebarToggled') === 'true';
        const savedPinned = localStorage.getItem('sidebarPinned') === 'true';

        sidebarPinned = savedPinned;

        // Terapkan class berdasarkan state
        if (savedToggled && !sidebarPinned) {
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
        } else {
            $("body").removeClass("sidebar-toggled");
            $(".sidebar").removeClass("toggled");
        }

        // Terapkan status tombol pin
        if (sidebarPinned) {
            $("#btn-pin-sidebar").addClass("pinned").attr("title", "Lepas Tahan");
        }
    }

    $(document).ready(function () {

        loadSidebarState();

        setTimeout(function(){
            sidebarReady = true;
        }, 500);

        $(".sidebar").on("mouseenter", function () {

            if (!sidebarReady) return;

            if (!sidebarPinned) {
                $("body").removeClass("sidebar-toggled");
                $(".sidebar").removeClass("toggled");
            }
        });

        $(".sidebar").on("mouseleave", function () {

            if (!sidebarReady) return;

            if (!sidebarPinned) {
                $("body").addClass("sidebar-toggled");
                $(".sidebar").addClass("toggled");
                $('.sidebar .collapse').collapse('hide');
            }
        });

    });
</script>
