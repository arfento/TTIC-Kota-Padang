<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Barang;
use App\Persediaan;
use App\Rak;
use Illuminate\Http\Request;

class PersediaanController extends Controller
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
    public function indexperrak()
    {
        // $persediaan=Persediaan::all();
        // return view('persediaan.index',compact('persediaan'));
        $raks = Rak::orderBy('nomor_rak', 'asc')->withCount('persediaan')->get();
        return view('persediaan.index_perrak', ['raks' => $raks]);
    }

    public function index($id)
    {
        $persediaan = Persediaan::with(['Barang','Rak'])->where('rak_id', $id)->get();
        return view('persediaan.index', compact('persediaan') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        
        $barang= Barang::all();
        $rak= Rak::orderBy('nomor_rak', 'asc')->get();
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
            'tanggal_kadaluarsa'=>'date',
        ]);
        $persediaan=Persediaan::create($request->all());
        return redirect()->route('persediaan.index')->with('success','Data Berhasil Dimasukkan');
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
        $persediaan = Persediaan::with(['Barang','Rak'])->where('rak_id', $id)->get();
        return view('persediaan.index', compact('persediaan') );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_persediaan)
    {
        // dd($id_persediaan);
        $perkembangansiswa = collect([]);
        // $persediaan = Persediaan::with(['Barang','Rak'])->where('barang_id', $id_persediaan)->get();
       
        $barang= Barang::all();
        $rak = Rak::orderBy('nomor_rak', 'asc')->get();
        $persediaan=Persediaan::findOrFail($id_persediaan);
        // dd($persediaan);
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
            'tanggal_kadaluarsa'=>'nullable|date',
        ]);
        $persediaan=Persediaan::find($id_persediaan);
        $persediaan->update($request->all());
        return redirect()->view('persediaan.index')->with('success','Data Berhasil Diupdate');
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
        return redirect()->view('persediaan.index')->with('success','Data Berhasil Dihapus');
        //
    }
}
