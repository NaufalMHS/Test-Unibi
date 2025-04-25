<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'quantity',
    ];

    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'id_produk');
    }

    public function transaksi()
    {
        return $this->belongsTo(MasterTransaksi::class, 'id_transaksi');
    }
}
