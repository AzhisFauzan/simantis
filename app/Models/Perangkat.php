<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    // Sesuaikan nama tabel
    protected $table = 'perangkat';

    // Set primary key karena default laravel adalah 'id'
    protected $primaryKey = 'id_perangkat';

    // Disable timestamps karena di tabel tidak ada created_at & updated_at
    public $timestamps = false;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'kode_inventaris',
        'nama_perangkat',
        'id_kategori',
        'merk',
        'spesifikasi',
        'id_ruangan',
        'kondisi'
    ];

    // Relasi ke tabel Kategori Perangkat
    public function kategori()
    {
        return $this->belongsTo(KategoriPerangkat::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke tabel Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id_ruangan');
    }
}
