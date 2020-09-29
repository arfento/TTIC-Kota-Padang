<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = ['kode_barang', 'nama_barang', 'jenis_barang_id', 'satuan_pembelian_id', 'isi', 'satuan_penjualan_id', 'harga_beli', 'harga_jual', 'gambar', 'keterangan'];
    protected $primaryKey = 'id_barang';
    // protected $uploads = '/uploads/gambar/' ;
    // protected $guarded=[];

    // public function getGambarAttribute($gambar)
    // {
    //     return $this->uploads . $gambar ;
    // }

    public function persediaan()
    {
        return $this->hasMany(Persediaan::class, 'barang_id');
    }

    public function getpersediaanCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->persediaan as $data) {
            $pcsCount += $data->stok;
        }

        return $pcsCount;
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function jenis()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id');
    }

    public function satuanPembelian()
    {
        return $this->belongsTo(satuanPembelian::class, 'satuan_pembelian_id');
    }

    public function satuanPenjualan()
    {
        return $this->belongsTo(SatuanPenjualan::class, 'satuan_penjualan_id');
    }    
}
