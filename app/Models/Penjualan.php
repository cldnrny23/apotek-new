<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    protected $guarded = [];

    protected $casts = [
        'tgl_penjualan' => 'datetime',
        'ongkos_kirim' => 'decimal:2',
        'biaya_app' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'snap_token' => 'string',
        'midtrans_order_id' => 'string',
    ];

    protected $dates = [
        'tgl_penjualan',
    ];

    public function metodeBayar()
    {
        return $this->belongsTo(MetodeBayar::class, 'id_metode_bayar');
    }

    public function jenisPengiriman()
    {
        return $this->belongsTo(JenisPengiriman::class, 'id_jenis_kirim');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'id_penjualan');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

    public function awaitingPaymentVerification(): bool
    {
        return $this->status_order === 'Menunggu Konfirmasi'
            && str_contains(strtolower($this->keterangan_status ?? ''), 'menunggu verifikasi admin');
    }
}
