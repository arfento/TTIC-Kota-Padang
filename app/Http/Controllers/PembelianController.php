<?php

namespace App\Http\Controllers;

use App\Pembelian;
use App\Supplier;
use App\User;
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
    public function store(Request $request)
    {
        $request->validate([
            'nomor_faktur'=>'required|string',
            'user_id'=>'required|numeric',
            'supplier_id'=>'required|numeric',
            'tanggal_pembelian'=>'required|date',
            'total'=>'required|numeric',
        ]);
        $pembelian=Pembelian::create($request->all());
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
}
