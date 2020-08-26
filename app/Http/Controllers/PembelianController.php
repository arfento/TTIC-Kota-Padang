<?php

namespace App\Http\Controllers;

use App\Barang;
use App\User;
use App\Supplier;
use App\Pembelian;
use App\Persediaan;
use App\DetailPembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $sales = DB::table('order_lines')
        // ->join('orders', 'orders.id', '=', 'order_lines.order_id')
        // ->select(DB::raw('sum(order_lines.quantity*order_lines.per_qty) AS total_sales'))
        // ->where('order_lines.product_id', $product->id)
        // ->where('orders.order_status_id', 4)
        // ->first();
        $pembelian=Pembelian::all();
        return view('pembelian.index',compact('pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $user= User::all();
        $supplier = Supplier::all();
        return view('pembelian.create', compact('user', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_rak)
    {
        $request->validate([
            'nomor_faktur'      => 'required|string',
            'user_id'           => 'required|numeric',
            'supplier_id'       => 'required|numeric',
            'tanggal_pembelian' => 'required|date',
            'total'             => 'required|numeric',
        ]);

        Pembelian::create([
            'nomor_faktur'      => $request -> nomor_faktur,
            'user_id'           => $request -> user_id,
            'supplier_id'       => $request -> supplier_id,
            'tanggal_pembelian' => $request -> tanggal_pembelian,
            'total'             => $request -> total
        ]);

        for ($i=0; $i < count($request->detail_pembelian); $i++) { 
            DetailPembelian::create([
                'pembelian_id'      => $this->getPembelianID($request->nomor_faktur),
                'barang_id'         => $request->detail_pembelian[$i]['barang_id'],
                'jumlah'         => $request->detail_pembelian[$i]['jumlah'],
                'harga_satuan'      => $request->detail_pembelian[$i]['harga_satuan'],
            ]);

            $isi = Barang::where('id_barang', $request->detail_pembelian[$i]['barang_id'])->first()->isi;
            $stok = $isi * $request->detail_pembelian[$i]['jumlah'];

            Persediaan::create([
                'rak_id'                => $id_rak,
                'barang_id'             => $request->detail_pembelian[$i]['barang_id'],
                'stok'                  => $stok
            ]);

            Barang::where('id_barang', $request->detail_pembelian[$i]['barang_id'])->update([
                'harga_beli'           => $request->detail_pembelian[$i]['harga_satuan']
            ]);
        }

        // $pembelian=Pembelian::create($request->all());
        return redirect()->route('pembelian.index')->with('pesan','Data Berhasil Dimasukkan');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pembelian)
    {
        $user= User::all();
        $supplier = Supplier::all();
        $pembelian=Pembelian::findOrFail($id_pembelian);
        return view('pembelian.edit',compact('pembelian', 'user', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pembelian)
    {
        
        $request->validate([
            'nomor_faktur'=>'required|string',
            'user_id'=>'required|numeric',
            'supplier_id'=>'required|numeric',
            'tanggal_pembelian'=>'required|date',
            'total'=>'required|numeric',
        ]);
        $pembelian=Pembelian::find($id_pembelian);
        $pembelian->update($request->all());
        return redirect()->route('pembelian.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pembelian)
    {
        $pembelian=Pembelian::find($id_pembelian);
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('pesan','Data Berhasil Dihapus');
        //
    }

    public function getPembelianID($nomorFaktur) {
        $data = Pembelian::where('nomor_faktur', $nomorFaktur)->first();
        return $data->id;
    }
}
