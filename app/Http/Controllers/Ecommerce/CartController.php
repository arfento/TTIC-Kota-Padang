<?php

namespace App\Http\Controllers\Ecommerce;

use DB;
use Mail;
use Cookie;
use App\City;
use App\Order;
use App\Barang;
use App\Product;
use App\Customer;
use App\District;
use App\Province;
use App\OrderDetail;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\CustomerRegisterMail;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
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
        $this->validate($request, [
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required',
            'email' => 'required|email',
            'customer_address' => 'required|string',
            // 'province_id' => 'required|exists:provinces,id',
            // 'city_id' => 'required|exists:cities,id',
            // 'district_id' => 'required|exists:districts,id',
            // 'courier' => 'required'
        ]);

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
                return $q['jumlah'] * $q['product_price'];
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
            $order = Order::create([
                'invoice' => Str::random(4) . '-' . time(),
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'district_id' => $request->district_id,
                'subtotal' => $subtotal,
                'cost' => $shipping[2],
                'shipping' => $shipping[0] . '-' . $shipping[1],
                'ref' => $affiliate != '' && $explodeAffiliate[0] != auth()->guard('customer')->user()->id ? $affiliate:NULL
            ]);

            foreach ($carts as $row) {
                $product = Product::find($row['product_id']);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product_id'],
                    'price' => $row['product_price'],
                    'jumlah' => $row['jumlah'],
                    'weight' => $product->weight
                ]);
            }

            DB::commit();

            $carts = [];
            $cookie = cookie('carts', json_encode($carts), 2880);
            Cookie::queue(Cookie::forget('afiliasi'));

            if (!auth()->guard('customer')->check()) {
                Mail::to($request->email)->send(new CustomerRegisterMail($customer, $password));
            }
            return redirect(route('front.finish_checkout', $order->invoice))->cookie($cookie);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

//     public function checkoutFinish($invoice)
//     {
//         $order = Order::with(['district.city'])->where('invoice', $invoice)->first();
//         return view('ecommerce.checkout_finish', compact('order'));
//     }

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
