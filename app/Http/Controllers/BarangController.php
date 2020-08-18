<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\JenisBarang;
use App\SatuanPembelian;
use App\SatuanPenjualan;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=Barang::all();
        return view('barang.index',compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $satuanpembelian= SatuanPembelian::all();
        $satuanpenjualan = SatuanPenjualan::all();
        $jenisbarang = JenisBarang::all();
        $barang = Barang::all();
        return view('barang.create', compact('satuanpembelian', 'satuanpenjualan', 'jenisbarang'));
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
            'kode_barang'=>'required',
            'nama_barang'=>'required',
            'jenis_barang_id'=>'required',
            'satuan_pembelian_id'=>'required',
            'isi'=>'required',
            'satuan_penjualan_id'=>'required',
            'harga_beli'=>'required',
            'harga_jual'=>'required',
            'stok'=>'required',
        ]);
        $barang=Barang::create($request->all());
        return redirect()->route('barang.index')->with('pesan','Data Berhasil Dimasukkan');
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
    public function edit($id_barang)
    {
        $satuanpembelian= SatuanPembelian::all();
        $satuanpenjualan = SatuanPenjualan::all();
        $jenisbarang = JenisBarang::all();
        $barang=Barang::findOrFail($id_barang);
        return view('barang.edit',compact('barang', 'satuanpembelian', 'satuanpenjualan', 'jenisbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_barang)
    {
        
        $request->validate([
            'kode_barang'=>'required',
            'nama_barang'=>'required',
            'jenis_barang_id'=>'required',
            'satuan_pembelian_id'=>'required',
            'isi'=>'required',
            'satuan_penjualan_id'=>'required',
            'harga_beli'=>'required',
            'harga_jual'=>'required',
            'stok'=>'required',
        ]);
        $barang=Barang::find($id_barang);
        $barang->update($request->all());
        return redirect()->route('barang.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_barang)
    {
        $barang=Barang::find($id_barang);
        $barang->delete();
        return redirect()->route('barang.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
