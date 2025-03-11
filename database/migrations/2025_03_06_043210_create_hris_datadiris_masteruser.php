<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('hris_datadiris_masteruser', function (Blueprint $table) {
        $table->id();
        $table->string('nik');
        $table->string('name');
        $table->string('role');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('hris_datadiris_detail');
}
};
