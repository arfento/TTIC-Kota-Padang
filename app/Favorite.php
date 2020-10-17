<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $primaryKey = 'id_favorite';
    protected $guarded= [];

  
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
