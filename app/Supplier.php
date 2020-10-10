<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama_supplier', 'email_supplier', 'telepon','alamat_supplier'];
    protected $primaryKey='id_supplier';

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }
}
