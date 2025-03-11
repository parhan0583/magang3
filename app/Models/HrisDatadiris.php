<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisDatadiris extends Model
{
    use HasFactory;
    // Tentukan nama tabel jika berbeda dengan nama model (opsional)
    protected $table = 'hris_datadiris';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'printid', 'employeid', 'perusahaanid', 'nik', 'foto', 'pathfoto',
        'filenamefoto', 'nm_lengkap', 'nm_panggilan', 'tmpt_lahir', 'tgl_lahir',
        'jns_kelamin', 'usia', 'tinggi_badan', 'berat_badan', 'status_kawin',
        'agama', 'alamat_ktp', 'alamat_domisili', 'status_domisili', 'upload_ktp',
        'tlp', 'hp', 'email', 'email2', 'gol_darah', 'kegemaran', 'sim', 'kewarganegaraan',
        'kendaraan', 'merk_kendaraan', 'thn_kendaraan', 'jabatan', 'sts_rsgn', 'sts_karyawan'
    ];

    // Jika Anda ingin menambahkan hubungan (relasi) dengan tabel lain, Anda bisa menambahkan metode relasi di sini.
}

