<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisPengirimansTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_pengirimans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kirim', ['ekonomi', 'kargo', 'regular', 'same day', 'standar']);
            $table->string('nama_ekspedisi');
            $table->string('logo_ekspedisi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_pengirimans');
    }
}

