<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PengaduanMasukCtrl extends Controller
{
    public function index()
    {
        return redirect('/maintenance/maintenance');
    }
}