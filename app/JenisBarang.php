<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $fillable = ['jenis'];
    public $timestamps = false;

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
