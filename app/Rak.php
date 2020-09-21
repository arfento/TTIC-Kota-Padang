<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $fillable = ['nomor_rak'];
    protected $primaryKey ='id_rak';
    

    public function persediaan()
    {
        return $this->hasMany(Persediaan::class, 'rak_id');
    }


    public function getpersediaanCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->persediaan as $data) {
            $pcsCount += $data->stok;
        }

        return count($this->persediaan).' barang, '.$pcsCount.' stok';
    }
}
