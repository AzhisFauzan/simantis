<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardCtrl extends Controller
{
    public function dashboard()
    {
        $userCount = DB::table('users')->count();
        $perangkatCount = DB::table('perangkat')->count();
        $maintenanceCount = DB::table('maintenance')->distinct()->count('id_ruangan');
        $ruanganCount = DB::table('ruangan')->count();

        return view('dashboard', compact('userCount', 'perangkatCount', 'maintenanceCount', 'ruanganCount'));
    }
}
