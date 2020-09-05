<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $fillable = ['jenis'];

	protected $primaryKey='id_jenis_barang';

    public function barang()
    {
        return $this->hasMany(Barang::class, 'jenis_barang_id');
    }
}
