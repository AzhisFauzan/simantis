<?php

use App\Http\Controllers\PengaduanApiCtrl;
use Illuminate\Support\Facades\Route;

Route::post('/terima-pengaduan', [PengaduanApiCtrl::class, 'terimaPengaduan']);
