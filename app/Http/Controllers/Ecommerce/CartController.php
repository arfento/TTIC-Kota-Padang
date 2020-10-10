<?php

namespace App\Http\Controllers\Ecommerce;

use DB;
use Mail;
use Cookie;
use App\City;
use App\Barang;
use App\Customer;
use App\District;
use App\Province;
use App\Penjualan;
use Midtrans\Snap;
use App\Persediaan;
use GuzzleHttp\Client;
use App\DetailPenjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CustomerRegisterMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private function getCarts()
    {
        $carts = json_decode(request()->cookie('carts'), true);
        $carts = $carts != '' ? $carts:[];
        return $carts;
    }

    public function addToCart(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'barang_id' => 'required|exists:barangs,id_barang',
            'jumlah' => 'required|integer'
        ]);

        $carts = $this->getCarts();
        if ($carts && array_key_exists($request->barang_id, $carts)) {
            $carts[$request->barang_id]['jumlah'] += $request->jumlah;
        } else {
            $barang = Barang::find($request->barang_id);
            $carts[$request->barang_id] = [
                'jumlah' => $request->jumlah,
                'barang_id' => $barang->id_barang,
                'nama_barang' => $barang->nama_barang,
                'harga_jual' => $barang->harga_jual,
                // 'satuanpenjualan' => $barang->satuanPenjualan->satuan,
                'gambar' => $barang->gambar,
            ];
        }

        $cookie = cookie('carts', json_encode($carts), 2880);
        // dd($carts);
        return redirect()->back()->with(['success' => 'Barang Ditambahkan ke Keranjang'])->cookie($cookie);
    }

    public function listCart()
    {
        $carts = $this->getCarts();
        $subtotal = collect($carts)->sum(function($q) {
            return $q['jumlah'] * $q['harga_jual'];
        });
        return view('ecommerce.cart', compact('carts', 'subtotal'));
    }

    public function updateCart(Request $request)
    {
        $carts = $this->getCarts();
        foreach ($request->barang_id as $key => $row) {
            if ($request->jumlah[$key] == 0) {
                unset($carts[$row]);
            } else {
                $carts[$row]['jumlah'] = $request->jumlah[$key];
            }
        }
        $cookie = cookie('carts', json_encode($carts), 2880);
        return redirect()->back()->cookie($cookie);
    }

    public function checkout()
    {
        // $provinces = Province::orderBy('created_at', 'DESC')->get();
        $carts = $this->getCarts();
        $subtotal = collect($carts)->sum(function($q) {
            return $q['jumlah'] * $q['harga_jual'];
        });
        // $weight = collect($carts)->sum(function($q) {
        //     return $q['jumlah'] * $q['satuanpenjualan'];
        // });
        return view('ecommerce.checkout', compact(/* 'provinces', */ 'carts', 'subtotal'/* , 'weight' */));
    }

//     public function getCity()
//     {
//         $cities = City::where('province_id', request()->province_id)->get();
//         return response()->json(['status' => 'success', 'data' => $cities]);
//     }

//     public function getDistrict()
//     {
//         $districts = District::where('city_id', request()->city_id)->get();
//         return response()->json(['status' => 'success', 'data' => $districts]);
//     }

    public function processCheckout(Request $request)
    {
        
        // $this->validate($request, [
        //     // 'nomor_faktur'=>'required|string',
        //     'user_id'=>'required|string',
        //     'user_nama' => 'required|string|max:100',
        //     'user_nohp' => 'required',
        //     'user_alamat' => 'required|email',
        //     'tanggal' => 'require|date',
        //     'total' => 'required|string',
        //     // 'province_id' => 'required|exists:provinces,id',
        //     // 'city_id' => 'required|exists:cities,id',
        //     // 'district_id' => 'required|exists:districts,id',
        //     // 'courier' => 'required'
        // ]);

        DB::beginTransaction();
        try {
            // $affiliate = json_decode(request()->cookie('afiliasi'), true);
            // $explodeAffiliate = explode('-', $affiliate);

            // $customer = Customer::where('email', $request->email)->first();
            // if (!auth()->guard('customer')->check() && $customer) {
            //     return redirect()->back()->with(['error' => 'Silahkan Login Terlebih Dahulu']);
            // }

            $carts = $this->getCarts();
            $subtotal = collect($carts)->sum(function($q) {
                return $q['jumlah'] * $q['harga_jual'];
            });

            // if (!auth()->guard('customer')->check()) {
            //     $password = Str::random(8);
            //     $customer = Customer::create([
            //         'name' => $request->customer_name,
            //         'email' => $request->email,
            //         'password' => $password,
            //         'phone_number' => $request->customer_phone,
            //         'address' => $request->customer_address,
            //         'district_id' => $request->district_id,
            //         'activate_token' => Str::random(30),
            //         'status' => false
            //     ]);
            // }

            // $shipping = explode('-', $request->courier);
            $order = Penjualan::create([
                'nomor_faktur' => Str::random(4),
                'user_id' => Auth::user()->id,
                'user_nama' => $request->user_nama,
                'user_nohp' => $request->user_nohp,
                'user_alamat' => $request->user_alamat,
                'tanggal' => $request->tanggal,
                'total' => $subtotal,
 
               ]);

            foreach ($carts as $row) {
                $barang = Barang::find($row['barang_id']);
                DetailPenjualan::create([
                    'penjualan_id' => $order->id_penjualan,
                    'barang_id' => $row['barang_id'],
                    'harga_satuan' => $row['harga_jual'],
                    'jumlah' => $row['jumlah'],
                    // 'weight' => $product->weight
                ]);
                $barang_id = $row['barang_id'];
                $jumlah = $row['jumlah'];

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

            ////midtrans
            $transaction_details = array(
                'order_id' => $schedule->id,
                'gross_amount' => $validate['location'] == 'barbershop' ? 35000 : 50000,
            );

            $user = auth()->user();

            //filling customer details
            $customer_details = array(
                'first_name'  => $user->userdetail->firstname,
                'last_name'   => $user->userdetail->lastname,
                'email'       => $user->email,
                'phone'       => $user->userdetail->phone,
                'billing_address' => null,
                'shipping_adress' => null,
            );

            $enabled_payments = array(
                "credit_card", "mandiri_clickpay", "cimb_clicks", "bca_klikbca", "bca_klikpay", "bri_epay", "echannel", "permata_va", "bca_va", "bni_va", "other_va", "gopay", "danamon_online"
            );

            $items = array();
            $dateParse = Carbon::parse($request->date.' '.$request->time);
            $items = Arr::prepend($items, array (
                'id' => $schedule->id,
                'price'   => $validate['location'] == 'barbershop' ? 35000 : 50000,
                'quantity' => 1,
                'name'    => 'Pembayaran untuk hari ' . $dateParse->locale('id_ID')->dayName . ', ' . $dateParse->format('d') . ' ' .  $dateParse->locale('id_ID')->monthName . ' ' . $dateParse->format('Y'),
            ));

            $expired = array(
                'start_time' => now()->format('Y-m-d H:i:s +0700'),
                'unit' => 'minute',
                'duration' => 60,
            );
            $params = array(
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $items,
                'enabled_payments' => $enabled_payments,
                'expiry' => $expired,
                'secure' => true,
            );

            // Generate SNAP Token
            $snapToken = Snap::getSnapToken($params);
            $schedule->snap_token = $snapToken;
            $schedule->save();

            $this->response['snap_token'] = $snapToken;
           ////midtrans

            DB::commit();

            $carts = [];
             //KOSONGKAN DATA KERANJANG DI COOKIE
            $cookie = cookie('carts', json_encode($carts), 2880);
           

           
            return redirect(route('front.finish_checkout', $order->nomor_faktur))->cookie($cookie);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    

    public function notificationHandler(Request $request) {
        $notif = new Notification();
        DB::transaction(function () use($notif) {
            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;
            $order = Schedule::where('id', $orderId)->first();

            if($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if($fraud == 'challenge') {
                        // TODO set payment status in merchant's database to 'Challenge by FDS'
                        // TODO merchant should decide whether this transaction is authorized or not in MAP
                        // $order->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                        $order->setPending();
                    } else {
                        // TODO set payment status in merchant's database to 'Success'
                        // $order->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                        $order->setSuccess();
                    }
                }
            } elseif ($transaction == 'settlement') {
                // TODO set payment status in merchant's database to 'Settlement'
                // $order->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
                $order->setSuccess();
            } elseif($transaction == 'pending'){
                // TODO set payment status in merchant's database to 'Pending'
                // $order->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
                $order->setPending();
            } elseif ($transaction == 'deny') {
                // TODO set payment status in merchant's database to 'Failed'
                // $order->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
                $order->setFailed();
            } elseif ($transaction == 'expire') {
                // TODO set payment status in merchant's database to 'expire'
                // $order->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
                $order->setExpired();
            } elseif ($transaction == 'cancel') {
                // TODO set payment status in merchant's database to 'Failed'
                // $order->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
                $order->setFailed();
            }
        });

        return;
    }







    

    public function checkoutFinish($invoice)
    {
        $order = Penjualan::where('nomor_faktur', $invoice)->first();
        return view('ecommerce.checkout_finish', compact('order'));
    }

//     public function getCourier(Request $request)
//     {
//         $this->validate($request, [
//             'destination' => 'required',
//             'weight' => 'required|integer'
//         ]);

//         $url = 'https://ruangapi.com/api/v1/shipping';
//         $client = new Client();
//         $response = $client->request('POST', $url, [
//             'headers' => [
//                 'Authorization' => 'd1JlYPgwNExLRQl6jUSyfZOCoN7SxpBk8bU6gN3D'
//             ],
//             'form_params' => [
//                 'origin' => 22,
//                 'destination' => $request->destination,
//                 'weight' => $request->weight,
//                 'courier' => 'jne,jnt'
//             ]
//         ]);

//         $body = json_decode($response->getBody(), true);
//         return $body;
//     }
}
