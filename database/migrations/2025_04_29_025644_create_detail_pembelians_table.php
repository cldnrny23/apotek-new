<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembeliansTable extends Migration
{
    public function up()
    {
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_obat');
            $table->integer('jumlah_beli');
            $table->double('harga_beli');
            $table->integer('subtotal');
            $table->unsignedBigInteger('id_pembelian');
            $table->timestamps();

            $table->foreign('id_obat')->references('id')->on('obats');
            $table->foreign('id_pembelian')->references('id')->on('pembelians');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pembelians');
    }
}
