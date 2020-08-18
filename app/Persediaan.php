<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $fillable = ['rak_id', 'barang_id', 'stok', 'tanggal_kadaluarsa'];
    protected $primaryKey = 'id_persediaan';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
}
