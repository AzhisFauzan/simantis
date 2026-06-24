<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiCtrl extends Controller
{
    public function get()
    {
        return response()->json([
            'notif' => DB::table('notifikasi')
            ->orderByDesc('created_at')
            ->get(),

            'unread' => DB::table('notifikasi')
            ->where('is_read', 0)
            ->count()
        ]);
    }

    public function read()
    {
        DB::table('notifikasi')
            ->where('is_read', 0)
            ->update([
                'is_read' => 1
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function hapus(Request $request)
    {
        DB::table('notifikasi')
            ->whereIn('id', $request->ids)
            ->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function bersihkan()
    {
        DB::table('notifikasi')->truncate();

        return response()->json([
            'success' => true
        ]);
    }
}