<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduk extends Model
{
    use HasFactory;

    protected $table = 'master_produk';

    protected $fillable = [
        'produk',
        'stok',
        'harga',
    ];

    // Relasi ke detail transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk');
    }
}
