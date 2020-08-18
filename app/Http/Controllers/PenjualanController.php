<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\User;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan=Penjualan::all();
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
        return view('penjualan.create', compact('user'));
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
            'jumlah_bayar'=>'required|numeric',
            'total'=>'required|numeric',
            'user_id'=>'required|string',
        ]);
        $penjualan=Penjualan::create($request->all());
        return redirect()->route('penjualan.index')->with('pesan','Data Berhasil Dimasukkan');
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
            'jumlah_bayar'=>'required|numeric',
            'total'=>'required|numeric',
            'user_id'=>'required|string',
        ]);
        $penjualan=Penjualan::find($id_penjualan);
        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with('pesan','Data Berhasil Diupdate');
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
        return redirect()->route('penjualan.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
