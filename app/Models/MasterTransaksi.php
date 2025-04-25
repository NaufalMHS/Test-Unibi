<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTransaksi extends Model
{
    use HasFactory;

    protected $table = 'master_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'user_id'
    ];

    // Relasi ke detail transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
