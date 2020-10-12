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

    public static function reduceStock($barangId, $stok)
	{
		$inventory = self::where('barang_id', $barangId)->firstOrFail();

		if ($inventory->stok < $stok) {
			$product = Barang::findOrFail($barangId);
			throw new \App\Exceptions\OutOfStockException('The product '. $product->nama_barang .' is out of stock');
		}

		$inventory->stok = $inventory->stok - $stok;
		$inventory->save();
	}

	/**
	 * Increase stock product
	 *
	 * @param int $productId product ID
	 * @param int $qty       qty product
	 *
	 * @return void
	 */
	public static function increaseStock($barangId, $stok)
	{
		$inventory = self::where('product_id', $barangId)->firstOrFail();
		$inventory->stok = $inventory->stok + $stok;
		$inventory->save();
	}
}
