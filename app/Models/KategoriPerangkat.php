<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPerangkat extends Model
{
    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'kategori_perangkat';

    // Mendefinisikan primary key kustom
    protected $primaryKey = 'id_kategori';

    // Menonaktifkan timestamps karena tidak ada di tabel inventaris.sql
    public $timestamps = false;

    // Kolom yang diizinkan untuk diisi massal
    protected $fillable = [
        'nama_kategori'
    ];
}
