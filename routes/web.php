<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthCtrl, DashboardCtrl, UserCtrl, PerangkatCtrl,
    KategoriCtrl, LaporanCtrl, MaintenanceCtrl, RuanganCtrl, PengaduanMasukCtrl, NotifikasiCtrl
};

Route::get('/', [AuthCtrl::class, 'login'])->name('login');
Route::post('/login/check', [AuthCtrl::class, 'proses_login'])->name('login.check');

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [AuthCtrl::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardCtrl::class, 'dashboard']);

    Route::middleware(['role:admin'])->group(function () {

        # User
        Route::get('/user/data_user', [UserCtrl::class, 'data_user']);
        Route::post('/user/data_user', [UserCtrl::class, 'store_user']);
        Route::post('/user/data_user/{id}/update', [UserCtrl::class, 'update']);
        Route::get('/user/data_user/{id}/delete', [UserCtrl::class, 'delete_user']);

        # Kategori Perangkat
        Route::get('/kategori', [KategoriCtrl::class, 'data_kategori']);
        Route::post('/kategori/store', [KategoriCtrl::class, 'store_kategori']);
        Route::get('/kategori/{id}/delete', [KategoriCtrl::class, 'delete_kategori']);

        # Perangkat IT
        Route::get('/perangkat/data_perangkat/{id}', [PerangkatCtrl::class, 'data_perangkat']);
        Route::post('perangkat/data_perangkat/{id_perangkat}/move', [PerangkatCtrl::class, 'move']);
        Route::post('/perangkat/data_perangkat', [PerangkatCtrl::class, 'store_perangkat']);
        Route::post('/perangkat/data_perangkat/{id}/update', [PerangkatCtrl::class, 'update_perangkat']);
        Route::post('/perangkat/data_perangkat/{id}/delete', [PerangkatCtrl::class, 'delete_perangkat']);

        # Laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/inventaris', [LaporanCtrl::class, 'inventaris'])->name('laporan.inventaris');
            Route::get('/inventaris/print', [LaporanCtrl::class, 'inventarisPrint'])->name('laporan.inventaris.print');
            Route::get('/inventaris/excel', [LaporanCtrl::class, 'inventarisExcel'])->name('laporan.inventaris.excel');
            Route::get('/maintenance', [LaporanCtrl::class, 'maintenance'])->name('laporan.maintenance');
            Route::get('/maintenance/print', [LaporanCtrl::class, 'printMaintenance'])->name('laporan.maintenance.print');
        });

        Route::get('/notifikasi/get', [NotifikasiCtrl::class, 'get']);
        Route::post('/notifikasi/read', [NotifikasiCtrl::class, 'read']);
        Route::post('/notifikasi/hapus', [NotifikasiCtrl::class, 'hapus']);
        Route::post('/notifikasi/bersihkan', [NotifikasiCtrl::class, 'bersihkan']);
    });

    # Ruangan
    Route::get('/ruangan/data_ruangan', [RuanganCtrl::class, 'data_ruangan']);
    Route::post('/ruangan/data_ruangan', [RuanganCtrl::class, 'store_ruangan']);
    Route::post('/ruangan/data_ruangan/{id_ruangan}/update', [RuanganCtrl::class, 'update_ruangan']);
    Route::post('/ruangan/data_ruangan/{id_ruangan}/delete', [RuanganCtrl::class, 'delete_ruangan']);
    Route::get('/ruangan/ruangan', [RuanganCtrl::class, 'ruangan']);

    # Perangkat IT
    Route::get('/perangkat/data_perangkat/{id}', [PerangkatCtrl::class, 'data_perangkat']);
    Route::post('perangkat/data_perangkat/{id_perangkat}/move', [PerangkatCtrl::class, 'move']);
    Route::post('/perangkat/data_perangkat', [PerangkatCtrl::class, 'store_perangkat']);
    Route::post('/perangkat/data_perangkat/{id}/update', [PerangkatCtrl::class, 'update_perangkat']);
    Route::post('/perangkat/data_perangkat/{id}/delete', [PerangkatCtrl::class, 'delete_perangkat']);


    # Maintenance
    Route::get('/maintenance/maintenance', [MaintenanceCtrl::class, 'maintenance']);
    Route::get('maintenance/detail/{id}', [MaintenanceCtrl::class, 'detail_maintenance']);
    Route::get('maintenance/kategori-ruangan', [MaintenanceCtrl::class, 'kategoriRuangan']);
    Route::post('/maintenance/maintenance', [MaintenanceCtrl::class, 'store_maintenance']);
    Route::get('/maintenance/riwayat_maintenance', [MaintenanceCtrl::class, 'riwayat_maintenance']);
    Route::get('maintenance/detail-riwayat/{id}', [MaintenanceCtrl::class, 'detail_riwayat']);
    Route::post('/maintenance/destroy', [MaintenanceCtrl::class, 'destroy_maintenance']);
    Route::get('/maintenance/latest-data', [MaintenanceCtrl::class, 'get_latest_maintenance']);

    Route::get('/notifikasi/get', [NotifikasiCtrl::class, 'get']);
    Route::post('/notifikasi/read', [NotifikasiCtrl::class, 'read']);
    Route::post('/notifikasi/hapus', [NotifikasiCtrl::class, 'hapus']);
    Route::post('/notifikasi/bersihkan', [NotifikasiCtrl::class, 'bersihkan']);

    Route::post('/maintenance/selesaikan-pengaduan/{id}', [MaintenanceCtrl::class,'selesaikanMaintenance']);

    Route::get('/maintenance/terima/{id}', [MaintenanceCtrl::class, 'redirectTerimaPengaduan']);
});
