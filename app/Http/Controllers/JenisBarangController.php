<?php

namespace App\Http\Controllers;
use App\JenisBarang;

use Illuminate\Http\Request;

class JenisBarangController extends Controller
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
        $jenisbarang=JenisBarang::orderBy('jenis', 'ASC')->withCount('barang')->get();
        return view('jenisbarang.index',compact('jenisbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenisbarang.create');
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
            'jenis'=>'required',
        ]);
        $jenisbarang=JenisBarang::create($request->all());
        return redirect()->route('jenisbarang.index')->with('success','Data Berhasil Dimasukkan');
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
    public function edit($id_jenis_barang)
    {
        $jenisbarang=JenisBarang::findOrFail($id_jenis_barang);
        return view('jenisbarang.edit',compact('jenisbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_jenis_barang)
    {
        $request->validate([
            'jenis'=>'required',
        ]);
        $jenisbarang=JenisBarang::find($id_jenis_barang);
        $jenisbarang->update($request->all());
        return redirect()->route('jenisbarang.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jenis_barang)
    {
        $jenisbarang=JenisBarang::find($id_jenis_barang);
        $jenisbarang->delete();
        return redirect()->route('jenisbarang.index')->with('success','Data Berhasil Dihapus');
        //
    }
}
