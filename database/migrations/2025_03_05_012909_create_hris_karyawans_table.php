<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisKaryawansTable extends Migration
{
    public function up()
    {
        Schema::create('hris_karyawans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan')->length(11);
            $table->string('nik', 150);
            $table->string('id_perusahaan', 150);
            $table->integer('id_divisi')->length(11);
            $table->integer('id_depart')->length(10);
            $table->string('jabatan', 150);
            $table->string('ket_jab', 600);
            $table->integer('id_atasan')->length(11);
            $table->integer('id_atasan_tdk_lgsg')->length(11);
            $table->integer('id_manager')->length(11);
            $table->integer('id_gm')->length(11);
            $table->integer('id_direktur')->length(11);
            $table->string('jaminan_dokumen', 150);
            $table->text('keterangan');
            $table->date('tglmasuk');
            $table->string('masa_kontrak', 6);
            $table->string('perusahaan', 90);
            $table->string('sts_rsgn', 3);
            $table->date('tglresign')->nullable();
            $table->text('alasan_resign')->nullable();
            $table->timestamps(0); // Timestamp with no fractional seconds
        });
    }

    public function down()
    {
        Schema::dropIfExists('hris_karyawans');
    }
}
