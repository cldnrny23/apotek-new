<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $fillable = [
        'id_penjualan',
        'no_invoice',
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim',
        'nama_kurir',
        'telpon_kurir',
        'bukti_foto',
        'keterangan'
    ];

    protected $dates = [
        'tgl_kirim',
        'tgl_tiba',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    // Access jenisPengiriman through penjualan relationship
    public function getJenisPengirimanAttribute()
    {
        return $this->penjualan->jenisPengiriman ?? null;
    }
}
