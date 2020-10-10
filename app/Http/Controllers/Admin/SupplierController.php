<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
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
        $supplier=Supplier::orderBy('nama_supplier', 'ASC')->withCount('pembelian')->get();
        return view('supplier.index',compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
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
            'nama_supplier'=>'required',
            'email_supplier'=>'required',
            'telepon'=>'required',
            'alamat_supplier'=>'required',
        ]);
        $supplier=Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success','Data Berhasil Dimasukkan');
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
    public function edit($id_supplier)
    {
        $supplier=Supplier::findOrFail($id_supplier);
        return view('supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_supplier)
    {
        $request->validate([
            'nama_supplier'=>'required',
            'email_supplier'=>'required',
            'telepon'=>'required',
            'alamat_supplier'=>'required',
        ]);
        $supplier=Supplier::find($id_supplier);
        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_supplier)
    {
        $supplier=Supplier::find($id_supplier);
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success','Data Berhasil Dihapus');
        //
    }
}
