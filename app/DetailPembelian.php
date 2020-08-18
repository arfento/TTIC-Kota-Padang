<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    
    protected $fillable = ['pembelian_id', 'barang_id', 'jumlah', 'harga_satuan', 'tanggal_kadaluarsa'];
    protected $primaryKey = 'id_detail_pembelian';
   

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
