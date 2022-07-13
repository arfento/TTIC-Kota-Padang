<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'id_penjualan';


    protected $appends = ['customer_full_name'];
	
	public const CREATED = 'created';
	public const CONFIRMED = 'confirmed';
	public const DELIVERED = 'delivered';
	public const COMPLETED = 'completed';
	public const CANCELLED = 'cancelled';

	public const ORDERCODE = 'INV';

	public const PAID = 'paid';
	public const UNPAID = 'unpaid';

	public const STATUSES = [
		self::CREATED => 'Created',
		self::CONFIRMED => 'Confirmed',
		self::DELIVERED => 'Delivered',
		self::COMPLETED => 'Completed',
		self::CANCELLED => 'Cancelled',
	];


    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDetailPenjualanCountAttribute($value)
    {
        $pcsCount = 0;
        foreach ($this->detailPenjualan as $data) {
            $pcsCount += $data->jumlah;
        }

        return count($this->detailPenjualan) . ' item, ' . $pcsCount . ' pcs';
    }

    public static function getPeriode($request)
    {
        $array = array();
        $month = $request->from;
        $i = 0;
        while (date('Y-m', strtotime($month)) <= date('Y-m', strtotime($request->to))) {
            $array[$i] = $month;
            $month = date('Y-m', strtotime("+1 month", strtotime(date($month))));
            $i++;
        }

        return $array;
    }

    public static function getTotal($periode, $data)
    {
        $array = array();
        for ($i = 0; $i < count($periode); $i++) {
            for ($j = 0; $j < count($data); $j++) {
                if ($periode[$i] == $data[$j]['periode']) {
                    $array[$i] = intval($data[$j]['total']);
                    break;
                } else {
                    $array[$i] = 0;
                }
            }
        }
        return $array;
    }

    public function setPending()
    {
        $this->attributes['status'] = 'pending';
        self::save();
    }

    public function setSuccess()
    {
        $this->attributes['status'] = 'success';
        self::save();
    }


    public function setFailed()
    {
        $this->attributes['status'] = 'failed';
        self::save();
    }


    public function setExpired()
    {
        $this->attributes['status'] = 'expired';
        self::save();
    }





    public static function getDataPenjualan($request)
    {
        $barang_id = $request->barang_id;
        $from = $request->from;
        $to = $request->to;

        $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(jumlah) as total')
            ->join('detail_penjualans', 'penjualans.id_penjualan', '=', 'detail_penjualans.penjualan_id')
            ->where('detail_penjualans.barang_id', $barang_id)
            ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$to'")
            ->groupBy('periode')
            ->get();

        return $data;
    }

    public static function getAllDataPenjualan()
    {
        $array = [];
        for ($i = 0; $i < 12; $i++) {
            $array[$i] = '';
        }
        // $array[11] = '2018-02'; // diganti get month bulan sekarang
        $array[11] = date('Y-m');
        $i = 10;
        while ($i >= 0) {
            $array[$i] = date('Y-m', strtotime("-1 month", strtotime(date($array[$i + 1]))));
            $i--;
        }

        $data = Penjualan::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as periode, sum(total) as total')
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') >= '$array[0]' AND DATE_FORMAT(tanggal, '%Y-%m') <= '$array[11]'")
            ->groupBy('periode')
            ->get();

        return ['periode' => $array, 'data' => $data];
    }

    // public static function getData($type, $request)
    // {
    //     if ($request->barang_id == null) {
    //         $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(jumlah) as total')
    //             ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
    //             ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$request->from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$request->to'")
    //             ->groupBy('periode')
    //             ->get();
    //     } else {
    //         $data = Penjualan::selectRaw('DATE_FORMAT(penjualans.tanggal, "%Y-%m") as periode, sum(jumlah) as total')
    //             ->join('detail_penjualans', 'penjualans.id', '=', 'detail_penjualans.penjualan_id')
    //             ->where('detail_penjualans.barang_id', $request->barang_id)
    //             ->whereRaw("DATE_FORMAT(penjualans.tanggal, '%Y-%m') >= '$request->from' AND DATE_FORMAT(penjualans.tanggal, '%Y-%m') <= '$request->to'")
    //             ->groupBy('periode')
    //             ->get();
    //     }

    //     $array = array();
    //     foreach($data as $key => $value) {
    //         $array[$key] = $value[$type];
    //     }

    //     return $array;
    // }


    /**
	 * Define scope forUser
	 *
	 * @param Eloquent $query query builder
	 * @param User     $user  limit
	 *
	 * @return void
	 */
	public function scopeForUser($query, $user)
	{
		return $query->where('user_id', $user->id);
	}

	/**
	 * Generate order code
	 *
	 * @return string
	 */
	public static function generateCode()
	{
		$dateCode = self::ORDERCODE . '/' . date('Ymd') . '/';

		$lastOrder = self::select([DB::raw('MAX(penjualans.nomor_faktur) AS last_code')])
			->where('nomor_faktur', 'like', $dateCode . '%')
			->first();

		$lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
		
		$orderCode = $dateCode . '00001';
		if ($lastOrderCode) {
			$lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
			$nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
			
			$orderCode = $dateCode . $nextOrderNumber;
		}

		if (self::_isOrderCodeExists($orderCode)) {
			return generateOrderCode();
		}

		return $orderCode;
	}

	/**
	 * Check if the generated order code is exists
	 *
	 * @param string $orderCode order code
	 *
	 * @return void
	 */
	private static function _isOrderCodeExists($orderCode)
	{
		return Penjualan::where('nomor_faktur', '=', $orderCode)->exists();
	}

	/**
	 * Check order is paid or not
	 *
	 * @return boolean
	 */
	public function isPaid()
	{
		return $this->payment_status == self::PAID;
	}

	/**
	 * Check order is created
	 *
	 * @return boolean
	 */
	public function isCreated()
	{
		return $this->status == self::CREATED;
	}

	/**
	 * Check order is confirmed
	 *
	 * @return boolean
	 */
	public function isConfirmed()
	{
		return $this->status == self::CONFIRMED;
	}

	/**
	 * Check order is delivered
	 *
	 * @return boolean
	 */
	public function isDelivered()
	{
		return $this->status == self::DELIVERED;
	}

	/**
	 * Check order is completed
	 *
	 * @return boolean
	 */
	public function isCompleted()
	{
		return $this->status == self::COMPLETED;
	}

	/**
	 * Check order is cancelled
	 *
	 * @return boolean
	 */
	public function isCancelled()
	{
		return $this->status == self::CANCELLED;
	}

	/**
	 * Add full_name custom attribute to order object
	 *
	 * @return boolean
	 */
	public function getCustomerFullNameAttribute()
	{
		return "{$this->customer_first_name} {$this->customer_last_name}";
    }
    public function shipment()
	{
		return $this->hasOne('App\Shipment', 'penjualan_id');
	}
}
