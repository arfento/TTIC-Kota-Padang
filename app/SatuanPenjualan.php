<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanPenjualan extends Model
{
    protected $fillable = ['satuan'];

	protected $primaryKey='id_satuan_penjualan';
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
