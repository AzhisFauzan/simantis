<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengaduanApiCtrl extends Controller
{
    private function cekSecretKey(Request $request): bool
    {
        $token = $request->bearerToken();
        return $token === env('SIPITRS_SECRET_KEY', 'darmayu123');
    }

    public function terimaPengaduan(Request $request)
    {
        if (!$this->cekSecretKey($request)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'id_pengaduan'       => 'required|integer',
            'id_ruangan'         => 'required|integer',
            'nama_ruangan'       => 'nullable|string',
            'id_kategori'        => 'nullable|integer',
            'id_perangkat'       => 'nullable|integer',
            'kode_inventaris'    => 'nullable|string',
            'kategori_perangkat' => 'nullable|string',
            'merek_perangkat'    => 'nullable|string',
            'created_at'         => 'required|date',
            'deskripsi_masalah'  => 'required|string',
        ]);

        $namaRuangan = $validated['nama_ruangan'] ?? null;
        if (!$namaRuangan) {
            $ruangan = DB::table('ruangan')->where('id_ruangan', $validated['id_ruangan'])->first();
            $namaRuangan = $ruangan->nama_ruangan ?? 'Tidak diketahui';
        }

        $id = DB::table('pengaduan_masuk')->insertGetId([
            'id_pengaduan'       => $validated['id_pengaduan'],
            'id_ruangan'         => $validated['id_ruangan'],
            'nama_ruangan'       => $namaRuangan,
            'id_kategori'        => $validated['id_kategori'] ?? null,
            'id_perangkat'       => $validated['id_perangkat'] ?? null,
            'kode_inventaris'    => $validated['kode_inventaris'] ?? '-',
            'kategori_perangkat' => $validated['kategori_perangkat'] ?? '-',
            'merek_perangkat'    => $validated['merek_perangkat'] ?? '-',
            'deskripsi_masalah'  => $validated['deskripsi_masalah'],
            'status'             => 'Menunggu',
            'tanggal'            => $validated['created_at'],
            'created_at'         => Carbon::now('Asia/Jakarta'),
            'updated_at'         => Carbon::now('Asia/Jakarta'),
        ]);

        try {
            DB::table('notifikasi')->insert([
                'id_pengaduan' => $validated['id_pengaduan'],
                'judul'        => 'Pengaduan Baru',
                'pesan'        => 'Pengaduan baru dari ruangan ' . $namaRuangan,
                'type'         => 'pengaduan',
                'is_read'      => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            Log::info('NOTIFIKASI OK');

        } catch (\Exception $e) {
            Log::error('NOTIFIKASI GAGAL', [
                'msg' => $e->getMessage(),
                'db'  => DB::connection()->getDatabaseName(),
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message'    => 'Pengaduan berhasil diterima',
            'id_masuk'   => $id,
        ], 201);
    }
}
