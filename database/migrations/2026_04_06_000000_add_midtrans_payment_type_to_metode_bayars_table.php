<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('metode_bayars', function (Blueprint $table) {
            $table->string('midtrans_payment_type')->nullable()->after('url_logo');
        });
    }

    public function down()
    {
        Schema::table('metode_bayars', function (Blueprint $table) {
            $table->dropColumn('midtrans_payment_type');
        });
    }
};
