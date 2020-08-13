<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatuanPembelian extends Model
{
    protected $fillable = ['satuan'];
    public $timestamps = false;

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
