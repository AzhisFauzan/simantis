<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiCtrl extends Controller
{
    public function get()
    {
        $notif = DB::table('notifikasi')
            ->leftJoin('pengaduan_masuk', 'notifikasi.id_pengaduan', '=', 'pengaduan_masuk.id_pengaduan')
            ->select('notifikasi.*', 'pengaduan_masuk.status as status_pengaduan')
            ->orderByDesc('notifikasi.created_at')
            ->get();

        $belum_ditindak = $notif->filter(function ($item) {
            return $item->status_pengaduan === 'Menunggu' || $item->status_pengaduan === null;
        })->values();

        $sudah_ditindak = $notif->filter(function ($item) {
            return $item->status_pengaduan !== null && $item->status_pengaduan !== 'Menunggu';
        })->values();

        return response()->json([
            'notif'           => $notif,
            'belum_ditindak'  => $belum_ditindak,
            'sudah_ditindak'  => $sudah_ditindak,
            'unread'          => DB::table('notifikasi')
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