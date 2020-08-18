<?php

namespace App\Http\Controllers;

use App\Barang;
use App\Persediaan;
use App\Rak;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $persediaan=Persediaan::all();
        return view('persediaan.index',compact('persediaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $barang= Barang::all();
        $rak= Rak::all();
        return view('persediaan.create', compact('rak', 'barang'));
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
            'rak_id'=>'required|numeric',
            'barang_id'=>'required|numeric',
            'stok'=>'required|numeric',
            'tanggal_kadaluarsa'=>'required|date',
        ]);
        $persediaan=Persediaan::create($request->all());
        return redirect()->route('persediaan.index')->with('pesan','Data Berhasil Dimasukkan');
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
    public function edit($id_persediaan)
    {
        $barang= Barang::all();
        $rak= Rak::all();
        $persediaan=Persediaan::findOrFail($id_persediaan);
        return view('persediaan.edit',compact('persediaan', 'barang', 'rak'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_persediaan)
    {
        
        $request->validate([
            'rak_id'=>'required|numeric',
            'barang_id'=>'required|numeric',
            'stok'=>'required|numeric',
            'tanggal_kadaluarsa'=>'required|date',
        ]);
        $persediaan=Persediaan::find($id_persediaan);
        $persediaan->update($request->all());
        return redirect()->route('persediaan.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_persediaan)
    {
        $persediaan=Persediaan::find($id_persediaan);
        $persediaan->delete();
        return redirect()->route('persediaan.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
