<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanPenjualan extends Model
{
    protected $fillable = ['satuan'];
    public $timestamps = false;

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
