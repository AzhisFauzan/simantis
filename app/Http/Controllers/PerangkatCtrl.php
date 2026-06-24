<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;  

class PerangkatCtrl extends Controller
{
    public function data_perangkat($id)
    {
        $data_perangkat = DB::table('perangkat as a')
        ->join('kategori_perangkat as b', 'a.id_kategori', 'b.id_kategori')
        ->join('ruangan as c', 'a.id_ruangan', 'c.id_ruangan')
        ->where('a.id_ruangan', $id)
        ->select('a.*', 'b.nama_kategori')
        ->get();

        $data_kategori = DB::table('kategori_perangkat')->get();

        $data_ruangan = DB::table('ruangan')->where('id_ruangan', '=', $id)->first();

        $data_semua_ruangan = DB::table('ruangan')->where('id_ruangan', '!=', $id)->get();

        return view("perangkat.data_perangkat", compact(
            'data_perangkat',
            'data_kategori',
            'data_ruangan',
            'data_semua_ruangan'
        ));
    }

    public function move(Request $request, $id_perangkat)
    {
        $request->validate([
            'id_ruangan_tujuan' => 'required|exists:ruangan,id_ruangan',
            'tanggal_pindah'    => 'required|date',
        ]);

        $perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', 'b.id_kategori')
            ->select('a.*', 'b.nama_kategori')
            ->where('id_perangkat', $id_perangkat)
            ->first();

        if (!$perangkat) {
            return redirect()->back()->with('error', 'Perangkat tidak ditemukan.');
        }

        $user = Auth::user();

        DB::table('perangkat')
            ->where('id_perangkat', $id_perangkat)
            ->update([
                'id_ruangan'        => $request->id_ruangan_tujuan,
                'dipindahkan_oleh'  => $user->name,
                'role_pemindah'     => $user->role,
                'tanggal_pindah'    => $request->tanggal_pindah,
            ]);

        try {
            Http::withToken(env('SIMANTIS_SECRET_KEY', 'darmayu123'))
                ->post(env('SIPITRS_API_URL') . '/perangkat/move', [
                    'kode_inventaris'   => $perangkat->kode_inventaris,
                    'id_ruangan_tujuan' => $request->id_ruangan_tujuan,
                ]);
        } catch (\Exception $e) {
            Log::error('API Move SIPITRS gagal: ' . $e->getMessage());
        }

        $ruangan_tujuan = DB::table('ruangan')->where('id_ruangan', $request->id_ruangan_tujuan)->first();

        return redirect()->back()
            ->with('success',
                'Perangkat "' . $perangkat->nama_kategori . '" berhasil dipindahkan ke ' .
                $ruangan_tujuan->nama_ruangan . ' oleh ' .
                $user->name . ' (' . $user->role . ').'
            );
    }

    public function kategoriRuangan(){
        $data = DB::table('maintenance')->select('id_ruangan', 'id_kategori')->distinct()->get();

        $mapping = [];
        foreach($data as $row){
            $mapping[$row->id_ruangan][] = $row->id_kategori;
        }

        return response()->json($mapping);
    }


    public function store_perangkat(Request $request)
    {
        $request->validate([
            'kode_inventaris' => 'required',
            'alamat_ip'       => 'required',
            'id_kategori'     => 'required',
            'kondisi'         => 'required'
        ]);

        DB::table('perangkat')->insert([
            'kode_inventaris'  => $request->kode_inventaris,
            'alamat_ip'        => $request->alamat_ip,
            'id_kategori'      => $request->id_kategori,
            'merek'            => $request->merek,
            'spesifikasi'      => $request->spesifikasi,
            'kondisi'          => $request->kondisi,
            'tipe'             => $request->tipe,
            'id_ruangan'       => $request->id_ruangan,
            'dipindahkan_oleh' => null,
            'role_pemindah'    => null,
            'tanggal_pindah'   => null,
        ]);

        try {
            Http::withToken(env('SIMANTIS_SECRET_KEY', 'darmayu123'))
            ->post(env('SIPITRS_API_URL') . '/perangkat/store', [
                'id_ruangan'      => $request->id_ruangan,
                'kode_inventaris' => $request->kode_inventaris,
                'alamat_ip'       => $request->alamat_ip,
                'merek'           => $request->merek,
                'id_kategori'     => $request->id_kategori,
            ]);
        } catch (\Exception $e) {
            Log::error('API Store SIPITRS gagal: ' . $e->getMessage());
        }

        return back()->with('success', 'Data Perangkat berhasil ditambahkan.');
    }

    public function update_perangkat(Request $request, $id)
    {
        $old_perangkat = DB::table('perangkat')->where('id_perangkat', $id)->first();

        DB::table('perangkat')->where('id_perangkat', $id)->update([
            'kode_inventaris'  => $request->kode_inventaris,
            'alamat_ip'        => $request->alamat_ip,
            'id_kategori'      => $request->id_kategori,
            'merek'            => $request->merek,
            'spesifikasi'      => $request->spesifikasi,
            'kondisi'          => $request->kondisi,
            'tipe'             => $request->tipe,
            'id_ruangan'       => $request->id_ruangan,
            'dipindahkan_oleh' => null,
            'role_pemindah'    => null,
            'tanggal_pindah'   => null,
        ]);

        if ($old_perangkat) {
            try {
                Http::withToken(env('SIMANTIS_SECRET_KEY', 'darmayu123'))
                    ->post(env('SIPITRS_API_URL') . '/perangkat/update', [
                        'old_kode_inventaris' => $old_perangkat->kode_inventaris,
                        'id_ruangan'          => $request->id_ruangan,
                        'kode_inventaris'     => $request->kode_inventaris,
                        'alamat_ip'           => $request->alamat_ip,
                        'merek'               => $request->merek,
                        'id_kategori'         => $request->id_kategori,
                    ]);
            } catch (\Exception $e) {
                Log::error('API Update SIPITRS gagal: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Data Perangkat berhasil diperbarui.');
    }

    public function delete_perangkat($id)
    {
        $perangkat = DB::table('perangkat')->where('id_perangkat', $id)->first();

        if ($perangkat) {
            DB::table('perangkat')->where('id_perangkat', $id)->delete();

            try {
                Http::withToken(env('SIMANTIS_SECRET_KEY', 'darmayu123'))
                ->post(env('SIPITRS_API_URL') . '/perangkat/delete', [
                    'kode_inventaris' => $perangkat->kode_inventaris,
                ]);
            } catch (\Exception $e) {
                Log::error('API Delete SIPITRS gagal: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Data berhasil dihapus.');
    }
}