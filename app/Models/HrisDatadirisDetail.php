<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisDatadirisDetail extends Model
{
    use HasFactory;
    // Tentukan nama tabel jika diperlukan
    protected $table = 'hris_datadiri_details';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'id_nik', 'id_atasan_lgsg', 'id_atasan_tdk_lgsg'
    ];

    // Relasi antar model bisa ditambahkan di sini
}
