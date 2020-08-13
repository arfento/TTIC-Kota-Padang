<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama_supplier', 'email_supplier', 'telepon'];
    public $timestamps = false;

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
