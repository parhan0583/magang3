<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisDatadirisTable extends Migration
{
    public function up()
    {
        Schema::tab('hris_datadiris', function (Blueprint $table) {
            $table->increments('id');
            $table->string('printid', 150);
            $table->string('employeid', 150);
            $table->string('perusahaanid', 150);
            $table->string('nik', 60);
            $table->binary('foto')->nullable();
            $table->string('pathfoto', 600)->nullable();
            $table->string('filenamefoto', 300)->nullable();
            $table->text('nm_lengkap');
            $table->text('nm_panggilan');
            $table->string('tmpt_lahir', 300);
            $table->date('tgl_lahir');
            $table->string('jns_kelamin', 60);
            $table->string('usia', 9);
            $table->string('tinggi_badan', 9);
            $table->string('berat_badan', 9);
            $table->string('status_kawin', 60);
            $table->string('agama', 60);
            $table->text('alamat_ktp');
            $table->text('alamat_domisili');
            $table->string('status_domisili', 150);
            $table->string('upload_ktp', 765);
            $table->string('tlp', 60);
            $table->string('hp', 60);
            $table->string('email', 600);
            $table->string('email2', 600)->nullable();
            $table->string('gol_darah', 6);
            $table->text('kegemaran');
            $table->string('sim', 15);
            $table->string('kewarganegaraan', 150);
            $table->string('kendaraan', 60);
            $table->string('merk_kendaraan', 90);
            $table->string('thn_kendaraan', 12);
            $table->string('jabatan', 60);
            $table->string('sts_rsgn', 3);
            $table->string('sts_karyawan', 150);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hris_datadiris');
    }
}
