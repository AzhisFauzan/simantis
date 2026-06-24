<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardCtrl extends Controller
{
    public function dashboard()
    {
        return view("/dashboard");
    }
}
