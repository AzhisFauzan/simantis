<nav class="navbar navbar-expand navbar-light bg-white topbar shadow"
    style="position: sticky; top: 0; z-index: 999; min-height: 40px; padding: 0 1rem;">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div style="line-height: 2.0;">
        <span class="d-block font-weight-bold" style="font-size: 0.85rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">Selamat Datang,</span>
        <span class="d-block font-weight-bold" style="font-size: 0.70rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">{{ strtoupper(Auth::user()->name) }}</span>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item mx-2" style="display: flex; align-items: center;">
            <a class="nav-link py-1" href="#" id="alertsDropdownBtn" style="position: relative; display: flex; align-items: center;">
                <i class="fas fa-bell fa-lg" style="color: gray;"></i>
                <span id="notifBadge" class="badge badge-danger" style="position:absolute;top:15px;right:5px;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;padding:0;">
                    0
                </span>
            </a>

<div id="alertsDropdownMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                style="display:none; position:absolute; right:0; top:100%; width: 320px; max-height: 450px; overflow:hidden; border-radius: 12px; border: none; padding: 0;">

                {{-- Header --}}
                <div style="background: linear-gradient(135deg, #6b21a8, #7c3aed); padding: 14px 16px 10px; border-radius: 12px 12px 0 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span style="font-weight:700; color:#fff; font-size: 13px; letter-spacing: 0.3px;">
                            <i class="fas fa-bell" style="margin-right: 5px;"></i> Pusat Notifikasi
                        </span>
                        <a href="#" id="clearNotifBtn" style="font-size: 11px; color: #fca5a5; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-trash-alt"></i> Bersihkan
                        </a>
                    </div>

                    {{-- Tab Filter --}}
                    <div style="display: flex; gap: 6px;">
                        <button class="notif-tab active" data-tab="belum" style="flex:1; padding: 6px 0; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: all .2s; background: rgba(255,255,255,.95); color: #6b21a8;">
                            Belum Ditindak <span id="countBelum" style="background: #dc2626; color: #fff; border-radius: 10px; padding: 1px 6px; font-size: 10px; margin-left: 3px;">0</span>
                        </button>
                        <button class="notif-tab" data-tab="sudah" style="flex:1; padding: 6px 0; border: none; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: all .2s; background: rgba(255,255,255,.2); color: rgba(255,255,255,.8);">
                            Sudah Ditindak <span id="countSudah" style="background: #dc2626; color: #fff; border-radius: 10px; padding: 1px 6px; font-size: 10px; margin-left: 3px;">0</span>
                        </button>
                    </div>
                </div>

                {{-- Notification List --}}
                <div id="notifListContainer" style="max-height: 340px; overflow-y: auto;">
                    <p class="text-center small text-muted py-3 m-0">Memuat notifikasi...</p>
                </div>
            </div>
        </li>

        <li class="nav-item">
           <a class="nav-link py-1" href="#" id="userDropdownBtn" style="display: flex; align-items: center;">
                <i class="fas fa-user-circle fa-2x" style="margin-right: 10px; color: gray;"></i>
                <span class="d-none d-lg-block font-weight-bold" style="font-size: 0.85rem;">{{ ucfirst(Auth::user()->role) }}</span>
            </a>
            <div id="userDropdownMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in" style="display:none; position:absolute; right:0; top:100%;">
                <a class="dropdown-item" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Logout</a>
            </div>
        </li>
    </ul>
</nav>

<audio id="notifSound" preload="auto">
    <source src="{{ asset('/audio/notif.mp3') }}" type="audio/mpeg">
</audio>

{{-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2"><h6>Logout</h6></div>
            <div class="modal-body py-2">Apakah Anda yakin ingin logout?</div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>
</div> --}}


<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                </div>

                <h5 class="fw-bold mb-2" id="logoutModalLabel">Siap untuk keluar?</h5>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">Sesi Anda saat ini akan diakhiri. Anda harus login kembali untuk masuk.</p>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-medium" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ url('/logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 rounded-pill fw-medium shadow-sm">Ya, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modalTerimaNotif" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div class="modal-body text-center" style="padding: 24px;">
                <div style="width: 56px; height: 56px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-inbox" style="font-size: 24px; color: #3b82f6;"></i>
                </div>
                <h5 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Terima Pengaduan</h5>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Apakah Anda ingin terima pengaduan ini ke Maintenance?</p>
                
                <div style="display: flex; gap: 8px; justify-content: center;">
                    <button class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; background: #f1f5f9; color: #475569; border: none;">Batal</button>
                    <button class="btn btn-primary" id="btnTerimaNotif" style="border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; background: #3b82f6; border: none; color: #fff;">Terima</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Notif dropdown scrollbar */
    #notifListContainer::-webkit-scrollbar { width: 4px; }
    #notifListContainer::-webkit-scrollbar-track { background: transparent; }
    #notifListContainer::-webkit-scrollbar-thumb { background: #d4d4d8; border-radius: 4px; }

    .notif-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
        transition: background .15s;
    }
    .notif-item:hover { background: #f8fafc; }
    .notif-item:last-child { border-bottom: none; }

    .notif-item .notif-title {
        font-size: 12px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .notif-item .notif-message {
        font-size: 11.5px;
        color: #64748b;
        line-height: 1.4;
    }
    .notif-item .notif-time {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 600;
    }
    .notif-item .notif-status-badge {
        display: inline-block;
        font-size: 9.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: 0.3px;
    }
    .notif-status-badge.diterima { background: #dbeafe; color: #2563eb; }
    .notif-status-badge.diproses { background: #fef3c7; color: #d97706; }
    .notif-status-badge.selesai  { background: #dcfce7; color: #16a34a; }
    .notif-status-badge.pending  { background: #f1f5f9; color: #64748b; }

    .btn-delete-notif-new {
        position: absolute;
        right: 8px;
        top: 8px;
        background: none;
        border: none;
        color: #cbd5e1;
        cursor: pointer;
        font-size: 11px;
        padding: 4px;
        border-radius: 4px;
        transition: all .15s;
    }
    .btn-delete-notif-new:hover { color: #ef4444; background: #fef2f2; }

    .notif-empty {
        text-align: center;
        padding: 30px 16px;
        color: #94a3b8;
    }
    .notif-empty i { font-size: 28px; margin-bottom: 8px; display: block; color: #d4d4d8; }
    .notif-empty span { font-size: 12px; font-weight: 500; }
</style>

<script>
    let localNotifState = [];
    let belumDitindakState = [];
    let sudahDitindakState = [];
    let unreadCountState = 0;
    let lastUnreadCount = 0;
    let isMutating = false;
    let selectedPengaduanId = null;
    let activeTab = 'belum';
    const isDashboard = window.location.pathname === '/dashboard';

    $(document).on('click', '.notif-link', function(e) {
        e.preventDefault();

        selectedPengaduanId = $(this).data('pengaduan');

        $('#alertsDropdownMenu').hide();
        $('#modalTerimaNotif').modal('show');
    });

    $('#btnTerimaNotif').on('click', function () {

        if (!selectedPengaduanId) return;

        window.location.href = `/maintenance/terima/${selectedPengaduanId}`;
    });

    // Tab switching
    $(document).on('click', '.notif-tab', function() {
        activeTab = $(this).data('tab');

        // Update tab visual
        $('.notif-tab').each(function() {
            $(this).css({
                'background': 'rgba(255,255,255,.2)',
                'color': 'rgba(255,255,255,.8)'
            });
            $(this).removeClass('active');
        });
        $(this).css({
            'background': 'rgba(255,255,255,.95)',
            'color': '#6b21a8'
        });
        $(this).addClass('active');

        renderNotifikasi();
    });

    function getStatusBadgeClass(status) {
        if (!status) return 'pending';
        switch(status) {
            case 'Diterima': return 'diterima';
            case 'Diproses': return 'diproses';
            case 'Selesai':  return 'selesai';
            default:         return 'pending';
        }
    }

    function renderNotifikasi() {
        let container = document.getElementById('notifListContainer');
        container.innerHTML = '';

        let items = activeTab === 'belum' ? belumDitindakState : sudahDitindakState;

        if (items.length === 0) {
            let emptyIcon = activeTab === 'belum' ? 'fa-inbox' : 'fa-check-circle';
            let emptyText = activeTab === 'belum' ? 'Tidak ada notifikasi baru' : 'Belum ada yang ditindak';
            container.innerHTML = `
                <div class="notif-empty">
                    <i class="fas ${emptyIcon}"></i>
                    <span>${emptyText}</span>
                </div>
            `;
            return;
        }

        items.forEach(item => {
            const tanggal = new Date(item.created_at);
            const jam = tanggal.getHours().toString().padStart(2, '0');
            const menit = tanggal.getMinutes().toString().padStart(2, '0');
            const hari = tanggal.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });

            if (activeTab === 'belum') {
                // Belum ditindak — clickable to accept
                container.innerHTML += `
                    <div class="notif-item" data-id="${item.id}">
                        <button class="btn-delete-notif-new btn-delete-notif" data-id="${item.id}">
                            <i class="fas fa-times"></i>
                        </button>
                        <a href="#" class="notif-link" data-id="${item.id}" data-pengaduan="${item.id_pengaduan}"
                           style="text-decoration:none; color:inherit; display:block; padding-right: 20px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 3px;">
                                <span class="notif-title">${item.judul}</span>
                                <span class="notif-time">${hari} ${jam}:${menit}</span>
                            </div>
                            <div class="notif-message">${item.pesan}</div>
                        </a>
                    </div>
                `;
            } else {
                // Sudah ditindak — show status badge, no action
                let statusLabel = item.status_pengaduan || 'Pending';
                let badgeClass = getStatusBadgeClass(item.status_pengaduan);

                container.innerHTML += `
                    <div class="notif-item" data-id="${item.id}">
                        <button class="btn-delete-notif-new btn-delete-notif" data-id="${item.id}">
                            <i class="fas fa-times"></i>
                        </button>
                        <div style="padding-right: 20px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 3px;">
                                <span class="notif-title">${item.judul}</span>
                                <span class="notif-time">${hari} ${jam}:${menit}</span>
                            </div>
                            <div class="notif-message" style="margin-bottom: 4px;">${item.pesan}</div>
                            <span class="notif-status-badge ${badgeClass}">${statusLabel}</span>
                        </div>
                    </div>
                `;
            }
        });
    }

    function fetchNotifikasi() {
        if (isMutating) return;

        fetch('/notifikasi/get?' + new Date().getTime(), {
            cache: 'no-store'
        })
        .then(res => res.json())
        .then(data => {
            console.log('DATA NOTIF:', data);

            if (isDashboard && data.unread > lastUnreadCount) {
                document.getElementById('notifSound').play().catch(() => {});
            }

            lastUnreadCount = data.unread;
            localNotifState = data.notif;
            belumDitindakState = data.belum_ditindak;
            sudahDitindakState = data.sudah_ditindak;
            unreadCountState = data.unread;

            let badge = document.getElementById('notifBadge');

            // Update badge counts on tabs
            document.getElementById('countBelum').innerText = belumDitindakState.length;
            document.getElementById('countSudah').innerText = sudahDitindakState.length;

            if (isDashboard && unreadCountState > 0) {
                badge.style.display = 'flex';
                badge.innerText = unreadCountState;
            } else {
                badge.style.display = 'none';
            }

            renderNotifikasi();
        })
        .catch(err => console.error(err));
    }

    document.getElementById('userDropdownBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var userMenu = document.getElementById('userDropdownMenu');
        var alertsMenu = document.getElementById('alertsDropdownMenu');

        alertsMenu.style.display = 'none';
        userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    });

    document.getElementById('alertsDropdownBtn').addEventListener('click', function (e) {
        e.preventDefault();
        let menu = document.getElementById('alertsDropdownMenu');
        let userMenu = document.getElementById('userDropdownMenu');
        let badge = document.getElementById('notifBadge');

        userMenu.style.display = 'none';
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';

        if (menu.style.display === 'block' && badge.style.display !== 'none') {
            fetch('/notifikasi/read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(() => {
                unreadCountState = 0;
                badge.style.display = 'none';
                renderNotifikasi();
            });
        }
    });

    document.getElementById('notifListContainer').addEventListener('click', function(e) {
        let notifLink = e.target.closest('.notif-link');
        if (notifLink) {
            document.getElementById('alertsDropdownMenu').style.display = 'none';
            return;
        }

        let btnDelete = e.target.closest('.btn-delete-notif');
        if (btnDelete) {
            e.preventDefault();
            e.stopPropagation();

            isMutating = true;
            let id = btnDelete.getAttribute('data-id');

            localNotifState = localNotifState.filter(item => item.id.toString() !== id);
            belumDitindakState = belumDitindakState.filter(item => item.id.toString() !== id);
            sudahDitindakState = sudahDitindakState.filter(item => item.id.toString() !== id);

            document.getElementById('countBelum').innerText = belumDitindakState.length;
            document.getElementById('countSudah').innerText = sudahDitindakState.length;

            renderNotifikasi();

            fetch('/notifikasi/hapus', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ ids: [id] })
            }).then(() => {
                isMutating = false;
                fetchNotifikasi();
            }).catch(err => {
                console.error(err);
                isMutating = false;
            });
        }
    });

    document.getElementById('clearNotifBtn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        isMutating = true;
        localNotifState = [];
        belumDitindakState = [];
        sudahDitindakState = [];
        unreadCountState = 0;

        document.getElementById('countBelum').innerText = 0;
        document.getElementById('countSudah').innerText = 0;

        renderNotifikasi();

        fetch('/notifikasi/bersihkan', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        }).then(() => {
            isMutating = false;
            fetchNotifikasi();
        }).catch(err => {
            console.error(err);
            isMutating = false;
        });
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('userDropdownBtn').contains(e.target)) document.getElementById('userDropdownMenu').style.display = 'none';
        if (!document.getElementById('alertsDropdownBtn').contains(e.target) && !document.getElementById('alertsDropdownMenu').contains(e.target)) document.getElementById('alertsDropdownMenu').style.display = 'none';
    });

    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('userDropdownMenu').style.display = 'none';
        $('#logoutModal').modal('show');
    });

    fetchNotifikasi();
    setInterval(fetchNotifikasi, 5000);
</script>
