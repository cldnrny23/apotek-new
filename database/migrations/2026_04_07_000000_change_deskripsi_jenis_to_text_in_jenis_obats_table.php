<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeDeskripsiJenisToTextInJenisObatsTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE jenis_obats MODIFY deskripsi_jenis TEXT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE jenis_obats MODIFY deskripsi_jenis VARCHAR(255) NULL');
    }
}
