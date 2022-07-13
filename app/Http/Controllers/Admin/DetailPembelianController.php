<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Barang;
use App\DetailPembelian;
use App\Pembelian;
use Illuminate\Http\Request;

class DetailPembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detailpembelian=DetailPembelian::all();
        return view('detailpembelian.index',compact('detailpembelian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $pembelian= Pembelian::all();
        $barang = Barang::all();
        $detailpembelian = DetailPembelian::all();
        return view('detailpembelian.create', compact('pembelian', 'barang'));
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
            'barang_id'=>'required|numeric',
            'pembelian_id'=>'required|numeric',
            'jumlah'=>'required|numeric',
            'harga_satuan'=>'required|numeric',
            'tanggal_kadaluarsa'=>'required|date',
        ]);
        $detailpembelian=DetailPembelian::create($request->all());
        return redirect()->route('detailpembelian.index')->with('success','Data Berhasil Dimasukkan');
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
    public function edit($id_detail_pembelian)
    {
        $pembelian= Pembelian::all();
        $barang = Barang::all();
        $detailpembelian=DetailPembelian::findOrFail($id_detail_pembelian);
        return view('detailpembelian.edit',compact('detailpembelian', 'barang', 'pembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_detail_pembelian)
    {
        
        $request->validate([
            'barang_id'=>'required|numeric',
            'pembelian_id'=>'required|numeric',
            'jumlah'=>'required|numeric',
            'harga_satuan'=>'required|numeric',
            'tanggal_kadaluarsa'=>'required|date',
        ]);
        $detailpembelian=DetailPembelian::find($id_detail_pembelian);
        $detailpembelian->update($request->all());
        return redirect()->route('detailpembelian.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_detail_pembelian)
    {
        $detailpembelian=DetailPembelian::find($id_detail_pembelian);
        $detailpembelian->delete();
        return redirect()->route('detailpembelian.index')->with('success','Data Berhasil Dihapus');
        //
    }
}
