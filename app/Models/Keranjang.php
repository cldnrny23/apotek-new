<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Obat;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pelanggan', 'id_obat', 'harga', 'jumlah'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}

