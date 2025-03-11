<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrisDatadiriDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('hris_datadiri_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nik')->length(11);
            $table->integer('id_atasan_lgsg')->length(10);
            $table->integer('id_atasan_tdk_lgsg')->length(10);
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hris_datadiri_details');
    }
}
