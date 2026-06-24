<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganCtrl extends Controller
{
    public function ruangan(Request $request)
    {
        $lokasi = $request->get('lokasi', 'all');
        $search = $request->get('search', '');

        $ruangan = DB::table('ruangan')->orderBy('lokasi')->orderBy('nama_ruangan'); // ← tambah

        if ($lokasi !== 'all') {
            $ruangan->where('lokasi', $lokasi);
        }

        if ($search !== '') {
            $ruangan->where('nama_ruangan', 'like', '%' . $search . '%');
        }

        $data_ruangan = $ruangan->get();

        $daftar_lokasi = DB::table('ruangan')
            ->select('lokasi')
            ->distinct()
            ->orderBy('lokasi')
            ->pluck('lokasi');

        $ruangan2Query = DB::table('ruangan')
            ->select('id_ruangan as id', 'nama_ruangan')
            ->orderBy('lokasi')->orderBy('nama_ruangan'); // ← tambah

        if ($lokasi !== 'all') {
            $ruangan2Query->where('lokasi', $lokasi);
        }

        if ($search !== '') {
            $ruangan2Query->where('nama_ruangan', 'like', '%' . $search . '%');
        }

        $ruangan2 = $ruangan2Query->get();

        return view('ruangan.ruangan', compact('ruangan2', 'data_ruangan', 'daftar_lokasi', 'lokasi', 'search'));
    }

    public function data_ruangan(Request $request)
    {
        $lokasi = $request->get('lokasi', 'all');

        $ruanganQuery = DB::table('ruangan')->orderBy('lokasi')->orderBy('nama_ruangan');

        if ($lokasi !== 'all') {
            $ruanganQuery->where('lokasi', $lokasi);
        }

        $data_ruangan = $ruanganQuery->paginate(10);

        $all_ruangan = DB::table('ruangan')->orderBy('lokasi')->orderBy('nama_ruangan')->get();

        $daftar_lokasi = DB::table('ruangan')->select('lokasi')->distinct()->orderBy('lokasi')->pluck('lokasi');

        return view('ruangan.data_ruangan', compact(
            'data_ruangan',
            'daftar_lokasi',
            'lokasi',
            'all_ruangan'
        ));
    }

    public function store_ruangan(Request $request)
    {
        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi'       => $request->lokasi,
        ]);

        return redirect('/ruangan/data_ruangan')->with('success', 'Data Ruangan berhasil ditambahkan.');
    }

    public function update_ruangan(Request $request, $id_ruangan)
    {
        $ruangan = Ruangan::findOrFail($id_ruangan);
        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi'       => $request->lokasi,
        ]);

        return redirect('/ruangan/data_ruangan')->with('success', 'Data Ruangan berhasil diperbarui.');
    }

    public function delete_ruangan($id_ruangan)
    {
        $ruangan = Ruangan::findOrFail($id_ruangan);
        $ruangan->delete();

        return redirect('/ruangan/data_ruangan')->with('success', 'Data Ruangan berhasil dihapus.');
    }
}
