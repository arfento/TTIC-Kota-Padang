<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SatuanPenjualan;

class SatuanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuanpenjualan=SatuanPenjualan::all();
        return view('satuanpenjualan.index',compact('satuanpenjualan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satuanpenjualan.create');
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
            'satuan'=>'min:2|required',
        ]);
        $satuanpenjualan=SatuanPenjualan::create($request->all());
        return redirect()->route('satuanpenjualan.index')->with('pesan','Data Berhasil Dimasukkan');
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
    public function edit($id_satuan_penjualan)
    {
        $satuanpenjualan=SatuanPenjualan::findOrFail($id_satuan_penjualan);
        return view('satuanpenjualan.edit',compact('satuanpenjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_satuan_penjualan)
    {
        $request->validate([
            'satuan'=>'min:2|required',
        ]);
        $satuanpenjualan=SatuanPenjualan::find($id_satuan_penjualan);
        $satuanpenjualan->update($request->all());
        return redirect()->route('satuanpenjualan.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_satuan_penjualan)
    {
        $satuanpenjualan=SatuanPenjualan::find($id_satuan_penjualan);
        $satuanpenjualan->delete();
        return redirect()->route('satuanpenjualan.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
