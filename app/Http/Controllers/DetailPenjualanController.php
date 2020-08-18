<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailPenjualan;
use App\Penjualan;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detailpenjualan=detailpenjualan::all();
        return view('detailpenjualan.index',compact('detailpenjualan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $penjualan= Penjualan::all();
        $barang = Barang::all();
        $detailpenjualan = detailpenjualan::all();
        return view('detailpenjualan.create', compact('penjualan', 'barang', 'detailpenjualan'));
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
            'penjualan_id'=>'required|numeric',
            'barang_id'=>'required|numeric',
            'jumlah'=>'required|numeric',
            'harga_satuan'=>'required|numeric',
           
        ]);
        $detailpenjualan=DetailPenjualan::create($request->all());
        return redirect()->route('detailpenjualan.index')->with('pesan','Data Berhasil Dimasukkan');
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
    public function edit($id_detail_penjualan)
    {
        $penjualan= Penjualan::all();
        $barang = Barang::all();
        $detailpenjualan=DetailPenjualan::findOrFail($id_detail_penjualan);
        return view('detailpenjualan.edit',compact('detailpenjualan', 'barang', 'penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_detail_penjualan)
    {
        
        $request->validate([
            'penjualan_id'=>'required|numeric',
            'barang_id'=>'required|numeric',
            'jumlah'=>'required|numeric',
            'harga_satuan'=>'required|numeric',
            
        ]);
        $detailpenjualan=DetailPenjualan::find($id_detail_penjualan);
        $detailpenjualan->update($request->all());
        return redirect()->route('detailpenjualan.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_detail_penjualan)
    {
        $detailpenjualan=DetailPenjualan::find($id_detail_penjualan);
        $detailpenjualan->delete();
        return redirect()->route('detailpenjualan.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
