<?php

namespace App\Http\Controllers;
use App\Barang;
use App\SatuanPembelian;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class SatuanPembelianController extends Controller
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
        $countbarang =Barang::count();
        // $satuanpembelian=SatuanPembelian::orderby('satuan', 'ASC')->paginate(5);
        $satuanpembelian=SatuanPembelian::orderBy('satuan', 'ASC')->withCount('barang')->get();
        // $satuanpembelian=SatuanPembelian::select(['id_satuan_pembelian', 'satuan'])->withCount('barang')->get();
        // $count = SatuanPembelian::all()->count();
        // return view('satuanpembelian.index',compact('count'));
        return view('satuanpembelian.index',compact('satuanpembelian', 'countbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satuanpembelian.create');
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
        $satuanpembelian=SatuanPembelian::create($request->all());
        return redirect()->route('satuanpembelian.index')->with('success','Data Berhasil Dimasukkan');
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
    public function edit($id_satuan_pembelian)
    {
        $satuanpembelian=SatuanPembelian::findOrFail($id_satuan_pembelian);
        return view('satuanpembelian.edit',compact('satuanpembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_satuan_pembelian)
    {
        $request->validate([
            'satuan'=>'min:2|required',
        ]);
        $satuanpembelian=SatuanPembelian::find($id_satuan_pembelian);
        $satuanpembelian->update($request->all());
        return redirect()->route('satuanpembelian.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_satuan_pembelian)
    {
        $satuanpembelian=SatuanPembelian::find($id_satuan_pembelian);
        $satuanpembelian->delete();
        return redirect()->route('satuanpembelian.index')->with('success','Data Berhasil Dihapus');
        //
    }
    
}
