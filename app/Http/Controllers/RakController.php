<?php

namespace App\Http\Controllers;
use App\Rak;

use Illuminate\Http\Request;
use DB;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $raks=Rak::all();
        // $raks=DB::table('raks')->get();
        return view('rak.index',compact('raks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rak.create');
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
            'nomor_rak'=>'min:4|required',
        ]);
        $raks=Rak::create($request->all());
        return redirect()->route('rak.index')->with('pesan','Data Berhasil Dimasukkan');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rak $id_rak
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     *  @param  \App\Rak $id_rak
     * @return \Illuminate\Http\Response
     */
    public function edit(Rak $rak)
    {
        $arr['raks'] = $rak;
        return view('rak.edit')->with($arr);
        // $raks=Rak::find($rak);
        // return view('rak.edit',compact('raks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rak $rak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rak)
    {
        // $rak -> nomor_rak = $request->nomor_rak;
        // $rak -> save();
        // return redirect()->route('rak.index')->with('pesan','Data Berhasil Dihapus');;

        $request->validate([
            'nomor_rak'=>'required',
        ]);
        $raks=Rak::find($rak);
        $raks->update($request->all());
        return redirect()->route('rak.index')->with('pesan','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rak $id_rak
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_rak)
    {
        // DB::table('raks')->where('id_rak', $id_rak)->delete();

        // $id_rak->delete();
        Rak::destroy($id_rak);
        return redirect()->route('rak.index')->with('pesan','Data Berhasil Dihapus');
        //
    }
}
