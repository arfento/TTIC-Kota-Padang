<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = ['nomor_faktur', 'supplier_id', 'tanggal', 'total', 'user_id'];
    protected $primaryKey = 'id_pembelian';

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDetailPembelianCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->detailPembelian as $data) {
            $pcsCount += $data->jumlah;
        }

        return count($this->detailPembelian).' item, '.$pcsCount.' pcs';
    }
}
