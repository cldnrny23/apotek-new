<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurirs';
    protected $fillable = [
        'nama_kurir',
        'telpon_kurir',
        'alamat',
        'status'
    ];

    public function pengirimans()
    {
        return $this->hasMany(Pengiriman::class, 'id_kurir');
    }
}
