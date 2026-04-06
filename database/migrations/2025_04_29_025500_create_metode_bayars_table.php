<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodeBayarsTable extends Migration
{
    public function up()
    {
        Schema::create('metode_bayars', function (Blueprint $table) {
            $table->id();
            $table->string('metode_pembayaran');
            $table->string('tempat_bayar', 50)->nullable();
            $table->string('no_rekening', 25)->nullable();
            $table->string('url_logo', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metode_bayars');
    }
}

