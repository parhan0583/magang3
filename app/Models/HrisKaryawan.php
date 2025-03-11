<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisKaryawan extends Model
{
    use HasFactory;
    // Tentukan nama tabel jika berbeda dengan nama model (opsional)
    protected $table = 'hris_karyawans';

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'id_karyawan', 'nik', 'id_perusahaan', 'id_divisi', 'id_depart', 'jabatan', 'ket_jab',
        'id_atasan', 'id_atasan_tdk_lgsg', 'id_manager', 'id_gm', 'id_direktur', 'jaminan_dokumen',
        'keterangan', 'tglmasuk', 'masa_kontrak', 'perusahaan', 'sts_rsgn', 'tglresign', 'alasan_resign'
    ];
    // Anda juga bisa mendefinisikan relasi dengan model lain jika diperlukan.
}
