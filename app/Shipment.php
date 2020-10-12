<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public const PENDING = 'pending';
	public const SHIPPED = 'shipped';

	protected $fillable = [
		'user_id',
		'penjualan_id',
		'track_number',
		'status',
		'total_qty',
		'total_weight',
		'first_name',
		'last_name',
		'address1',
		'address2',
		'phone',
		'email',
		'city_id',
		'province_id',
		'postcode',
		'shipped_by',
		'shipped_at',
	];

	/**
	 * Relationship to the order model
	 *
	 * @return void
	 */
	public function penjualan()
	{
		return $this->belongsTo(\App\Penjualan::class, 'penjualan_id');
	}
	public function user()
	{
		return $this->belongsTo(\App\Penjualan::class, 'user_id');
	}

}
