<?php

// database/migrations/xxxx_xx_xx_create_penjualan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id('id')->primary()->autoIncrement();
            $table->unsignedBigInteger('id_metode_bayar')->nullable();
            $table->date('tgl_penjualan')->nullable();
            $table->string('url_resep', 255)->nullable();
            $table->double('ongkos_kirim')->nullable();
            $table->double('biaya_app')->nullable();
            $table->double('total_bayar')->nullable();
            $table->enum('status_order', [
                'Menunggu Konfirmasi Pembayaran', 'Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir',
                'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Selesai'
            ])->default('Menunggu Konfirmasi Pembayaran');
            $table->string('keterangan_status', 255)->nullable();
            $table->unsignedBigInteger('id_jenis_kirim')->nullable();
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->timestamps();

            $table->foreign('id_metode_bayar')->references('id')->on('metode_bayars');
            $table->foreign('id_jenis_kirim')->references('id')->on('jenis_pengirimans');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggans');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}

