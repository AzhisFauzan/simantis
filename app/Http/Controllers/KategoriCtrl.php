<?php

namespace App\Http\Controllers;

use App\Models\KategoriPerangkat;
use Illuminate\Http\Request;

class KategoriCtrl extends Controller
{
    public function data_kategori()
    {
        $data_kategori = KategoriPerangkat::all();
        return view("kategori.data_kategori", compact('data_kategori'));
    }

    public function store_kategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = KategoriPerangkat::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'status'        => 'success',
            'id_kategori'   => $kategori->id_kategori,
            'nama_kategori' => $kategori->nama_kategori,
        ]);
    }

    public function delete_kategori($id)
    {
        $kategori = KategoriPerangkat::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'status' => 'success',
            'id'     => $id
        ]);
    }
}
