<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    
    protected $fillable = ['pembelian_id', 'barang_id', 'jumlah', 'harga_satuan', 'tanggal_kadaluarsa'];
    public $timestamps = false;

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
