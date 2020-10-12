<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Barang;
use App\Penjualan;
use Carbon\Carbon;
use App\Persediaan;
use Midtrans\Config;
use App\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\OutOfStockException;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();

		$this->data['currentAdminMenu'] = 'order';
		$this->data['currentAdminSubMenu'] = 'order';
        $this->data['statuses'] = Penjualan::STATUSES;
        
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
       
        $penjualan=Penjualan::all();
        // $pembelian = Pembelian::orderBy('tanggal_pembelian', 'desc')->withCount('detailPembelian')->with('supplier')->with('user')->get();
        $data = Penjualan::orderBy('tanggal', 'desc')->orderBy('nomor_faktur', 'desc')->withCount('detailPenjualan')->with('user')->get();
       
        return view('penjualan.index',compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $user= User::all();
        $penjualan = Penjualan::all();
        $detailpenjualan = DetailPenjualan::all();
        $persediaan = Persediaan::all();
        $barang = Barang::all();
        // $random = uniqid();
        $random = mt_rand(100000000, 999999999);
        return view('penjualan.create', compact('user', 'penjualan', 'persediaan', 'barang', 'detailpenjualan', 'random'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'nomor_faktur'=>'required|string',
            'tanggal'=>'required|date',
            // 'total'=>'required|numeric',
            'user_id'=>'required|string',
            // 'user_nama'=>'required|string',
            // 'user_nohp'=>'required|string',
            // 'user_alamat'=>'required',
        ]);
        
        $total = 0;
        foreach ($request->total as $key => $value){
            $total += $value;
        }
        
        Penjualan::create([
            'nomor_faktur'  => $request->nomor_faktur,
            'tanggal'       => $request->tanggal,
            'total'         => $total,
            'user_id'       => $request->user_id,
            // 'user_nama'       => $request->user_nama,
            // 'user_nohp'       => $request->user_nohp,
            // 'user_alamat'       => $request->user_alamat,
        ]);

        foreach ($request->total as $key => $value){
            DetailPenjualan::create([
                'penjualan_id' => $this->getPenjualanID($request->nomor_faktur),
                'barang_id' => $request->barang_id[$key],
                'jumlah'       => $request-> jumlah[$key],
                'harga_satuan' => $request-> harga_satuan[$key],
            ]);

            $barang_id = $request-> barang_id[$key];
            $jumlah = $request-> jumlah[$key];

            $persediaan = Persediaan::where('barang_id', $barang_id)->get();

            $n = 0;
            for($j = 0; $j < count($persediaan); $j++){
                $stok = $persediaan[$j]['stok'];
                if(($n + $stok) > $jumlah) {
                    $terkurangi = $stok - (($n + $stok) - $jumlah);
                    Persediaan::where('id_persediaan', $persediaan[$j]['id_persediaan'])->update([
                        'stok' => ($stok - $terkurangi)
                    ]);
                    break;
                }
                $n += $persediaan[$j]['stok'];
                Persediaan::where('id_persediaan', $persediaan[$j]['id_persediaan'])->delete();
            }
        }
           
        // $penjualan=Penjualan::create($request->all());
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Dimasukkan');
        //

        

      
        // Pembelian::create([
        //     'nomor_faktur'      => $request->nomor_faktur,
        //     'user_id'           => $request->user_id,
        //     'supplier_id'       => $request->supplier_id,
        //     'tanggal_pembelian' => $request->tanggal_pembelian,
        //     'total'             => $total

            
        // ]);
        // $detail = array();
        // foreach ($request->total as $key => $value) {
        //     DetailPembelian::create([
        //         'barang_id' => $request->barang_id[$key],
        //         'pembelian_id' => $this->getPembelianID($request->nomor_faktur),
        //         'jumlah' => $request->jumlah[$key],
        //         'harga_satuan' => $request->harga_satuan[$key],
        //     ]);

        //     $isi = Barang::where('id_barang', $request->barang_id[$key])->first()->isi;
        //     $stok = $isi * $request->jumlah[$key];

        //     Persediaan::create([
        //         'rak_id'                => $request->rak_id[$key],
        //         'barang_id'             => $request->barang_id[$key],
        //         'stok'                  => $stok
        //     ]);

        //     Barang::where('id_barang', $request->barang_id[$key])->update([
        //         'harga_beli'           => $request->harga_satuan[$key],
        //     ]);

            
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Penjualan::withTrashed()->findOrFail($id);


		return view('penjualan.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_penjualan)
    {
        $user= User::all();
        $penjualan=Penjualan::findOrFail($id_penjualan);
        return view('penjualan.edit',compact('penjualan', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_penjualan)
    {
        
        $request->validate([
            'nomor_faktur'=>'required|string',
            'tanggal'=>'required|date',
            'total'=>'required|numeric',
            'user_id'=>'required|string',
            // 'user_nama'=>'required|string',
            // 'user_nohp'=>'required|string',
            // 'user_alamat'=>'required',
        ]);
        $penjualan=Penjualan::find($id_penjualan);
        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_penjualan)
    {
        $penjualan=Penjualan::find($id_penjualan);
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Dihapus');
        //





        // $order = Order::withTrashed()->findOrFail($id);

		// if ($order->trashed()) {
		// 	$canDestroy = \DB::transaction(
		// 		function () use ($order) {
		// 			OrderItem::where('order_id', $order->id)->delete();
		// 			$order->shipment->delete();
		// 			$order->forceDelete();

		// 			return true;
		// 		}
		// 	);

		// 	if ($canDestroy) {
		// 		\Session::flash('success', 'The order has been removed permanently');
		// 	} else {
		// 		\Session::flash('success', 'The order could not be removed permanently');
		// 	}

		// 	return redirect('admin/orders/trashed');
		// } else {
		// 	$canDestroy = \DB::transaction(
		// 		function () use ($order) {
		// 			if (!$order->isCancelled()) {
		// 				foreach ($order->orderItems as $item) {
		// 					ProductInventory::increaseStock($item->product_id, $item->qty);
		// 				}
		// 			};

		// 			$order->delete();

		// 			return true;
		// 		}
		// 	);
			
		// 	if ($canDestroy) {
		// 		\Session::flash('success', 'The order has been removed');
		// 	} else {
		// 		\Session::flash('success', 'The order could not be removed');
		// 	}

		// 	return redirect('admin/orders');
		// }
    }


    

    public function getPenjualanID($nomor_faktur) {
        $data = Penjualan::where('nomor_faktur', $nomor_faktur)->first();
        return $data->id_penjualan;
    }

    public function getPenjualan() {
        $data = Penjualan::getAllDataPenjualan();
        $periode = $data['periode'];
        $penjualan = Penjualan::getTotal($data['periode'],$data['data']);
        return response()->json(['periode' => $periode, 'penjualan' => $penjualan]);
    }

    public function getNomorFaktur() {
        $nextNomorFaktur = '';
        $data = Penjualan::orderBy('id_penjualan', 'desc')->first();
        $year = Carbon::today()->year;

        if(empty($data)){
            $nextNomorFaktur = 'RM'.substr($year, 2) . $this->addLeadingZero(1);
        }else{
            // $number = explode('-', $data); //RM17-00001
            $number = substr($data->nomor_faktur, 4);
            $before = $this->removeLeadingZero($number);
            $new = $this->addLeadingZero($before + 1);
            $nextNomorFaktur = 'RM'.substr($year, 2) . $new;
        }

        return response()->json($nextNomorFaktur);
    }

    public function addLeadingZero($value, $threshold = 5) {
        return sprintf('%0' . $threshold . 's', $value);
    }

    public function removeLeadingZero($value) {
        return (int)ltrim($value, '0');
    }





    public function trashed()
	{
		$orders = Penjualan::onlyTrashed()->orderBy('created_at', 'DESC')->paginate(10);

		return view('penjualan.trashed', compact('orders'));
    }
    


    public function cancel($id)
	{
		$order = Penjualan::where('id', $id)
			->whereIn('status', [Penjualan::CREATED, Penjualan::CONFIRMED])
			->firstOrFail();


		return view('penjualan.cancel', compact('order'));
	}



    public function doCancel(Request $request, $id)
	{
		$request->validate(
			[
				'cancellation_note' => 'required|max:255',
			]
		);

		$order = Penjualan::findOrFail($id);
		
		$cancelOrder = DB::transaction(
			function () use ($order, $request) {
				$params = [
					'status' => Penjualan::CANCELLED,
					'cancelled_by' => Auth::user()->id,
					'cancelled_at' => now(),
					'cancellation_note' => $request->input('cancellation_note'),
				];

                if ($cancelOrder = $order->update($params) && $order->orderItems->count() > 0) {
                    foreach ($order->DetailPenjualan as $item) {
                        Persediaan::increaseStock($item->barang_id, $item->jumlah);
                    }
                }
				return $cancelOrder;
			}
		);

		\Session::flash('success', 'The order has been cancelled');

		return redirect('admin/orders');
    }
    
    public function doComplete(Request $request, $id)
	{
		$order = Penjualan::findOrFail($id);
		
		if (!$order->isDelivered()) {
			\Session::flash('error', 'Mark as complete the order can be done if the latest status is delivered');
			return redirect('admin/orders');
		}

		$order->status = Penjualan::COMPLETED;
		$order->approved_by = Auth::user()->id;
		$order->approved_at = now();
		
		if ($order->save()) {
			\Session::flash('success', 'The order has been marked as completed!');
			return redirect('admin/orders');
		}
    }
    


    public function restore($id)
	{
		$order = Penjualan::onlyTrashed()->findOrFail($id);

		$canRestore = \DB::transaction(
			function () use ($order) {
				$isOutOfStock = false;
				if (!$order->isCancelled()) {
					foreach ($order->orderItems as $item) {
						try {
							Persediaan::reduceStock($item->barang_id, $item->jumlah);
						} catch (OutOfStockException $e) {
							$isOutOfStock = true;
							\Session::flash('error', $e->getMessage());
						}
					}
				};

				if ($isOutOfStock) {
					return false;
				} else {
					return $order->restore();
				}
			}
		);

		if ($canRestore) {
			\Session::flash('success', 'The order has been restored');
			return redirect('admin/orders');
		} else {
			if (!\Session::has('error')) {
				\Session::flash('error', 'The order could not be restored');
			}
			return redirect('penjualan/trashed');
		}
	}
}
