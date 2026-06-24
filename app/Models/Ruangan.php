<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    // Mendefinisikan nama tabel
    protected $table = 'ruangan';

    // Mendefinisikan primary key kustom
    protected $primaryKey = 'id_ruangan';

    // Menonaktifkan timestamps
    public $timestamps = false;

    protected $fillable = [
        'nama_ruangan',
        'lokasi'
    ];
}
