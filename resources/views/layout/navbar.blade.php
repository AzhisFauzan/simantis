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
                <span id="notifBadge" class="badge badge-danger" style="display:none;position:absolute;top:4px;right:-6px;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:10px;padding:0;">
                    0
                </span>
            </a>

            <div id="alertsDropdownMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                style="display:none; position:absolute; right:0; top:100%; width: 280px; max-height: 400px; overflow-y: auto;">
                <h6 class="dropdown-header d-flex justify-content-between align-items-center" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; padding: 10px 15px; margin-top: 0;">
                    <span style="font-weight:bold;color:#333;">Pusat Notifikasi <span id="notifCount">0</span></span>
                    <a href="#" id="clearNotifBtn" style="font-size: 0.75rem; color: #ef4444; text-decoration: none;">
                        <i class="fas fa-trash-alt"></i> Bersihkan
                    </a>
                </h6>
                <div id="notifListContainer">
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

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2"><h6>terima Logout</h6></div>
            <div class="modal-body py-2">Apakah Anda yakin ingin logout?</div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTerimaNotif" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Terima Pengaduan</h5>
            </div>

            <div class="modal-body">
                <p>Apakah Anda ingin terima pengaduan ini ke Maintenance?</p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-success" id="btnTerimaNotif">
                    Terima
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    let localNotifState = [];
    let unreadCountState = 0;
    let lastUnreadCount = 0;
    let isMutating = false;
    let selectedPengaduanId = null;

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

    function renderNotifikasi() {
        let container = document.getElementById('notifListContainer');
        container.innerHTML = '';

        if (localNotifState.length === 0) {
            container.innerHTML =
                '<p class="text-center small text-muted py-3 m-0">Tidak ada notifikasi.</p>';
            return;
        }

        localNotifState.forEach(item => {

            const tanggal = new Date(item.created_at);
            const jam = tanggal.getHours().toString().padStart(2, '0');
            const menit = tanggal.getMinutes().toString().padStart(2, '0');

            container.innerHTML += `
                <div class="dropdown-item"
                    style="padding:10px 15px;border-bottom:1px solid #eee;position:relative;">

                    <a href="#"
                    class="notif-link"
                    data-id="${item.id}"
                    data-pengaduan="${item.id_pengaduan}"
                    style="display:block;text-decoration:none;color:inherit;padding-right:25px;">

                        <span style="font-size:0.80rem;font-weight:600;">
                            ${item.judul}
                        </span>

                        <span style="font-size:0.70rem;font-weight:600;float:right;">
                            ${jam}:${menit}
                        </span>

                        <br>

                        <span style="font-size:0.75rem;">
                            ${item.pesan}
                        </span>
                    </a>

                    <button class="btn-delete-notif"
                            data-id="${item.id}"
                            style="position:absolute;right:5px;top:8px;background:none;border:none;color:red;">
                        <i class="fas fa-times"></i>
                    </button>

                </div>
            `;
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

            if (data.unread > lastUnreadCount) {
                document.getElementById('notifSound').play().catch(() => {});
            }

            lastUnreadCount = data.unread;
            localNotifState = data.notif;
            unreadCountState = data.unread;

            let badge = document.getElementById('notifBadge');
            let countSpan = document.getElementById('notifCount');

            if (unreadCountState > 0) {
                badge.style.display = 'flex';
                badge.innerText = unreadCountState;
            } else {
                badge.style.display = 'none';
            }

            countSpan.innerText = unreadCountState;

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
        unreadCountState = 0;
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
