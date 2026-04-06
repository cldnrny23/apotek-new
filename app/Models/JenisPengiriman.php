<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengiriman extends Model
{
    protected $table = 'jenis_pengirimans';

    protected $fillable = [
        'jenis_kirim',
        'nama_ekspedisi',
        'logo_ekspedisi',
        'ongkos_kirim'
    ];

    public function pengirimans()
    {
        return $this->hasMany(Pengiriman::class);
    }
}
