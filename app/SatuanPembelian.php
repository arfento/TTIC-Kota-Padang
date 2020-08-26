<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanPembelian extends Model
{
    protected $fillable = ['satuan'];

    protected $primaryKey='id_satuan_pembelian';
    
    public function barang()
    {
        return $this->hasMany(Barang::class, 'satuan_pembelian_id');
    }
}
