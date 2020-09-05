<?php

namespace App\Http\Controllers;

use App\Persediaan;
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
        // $raks = Rak::orderBy('id_rak', 'asc')->get();
        // $data = array();
        // for($i = 0; $i < count($raks); $i++) {
        //     $query = DB::select('SELECT rak_id, count(barang_id) as jumlah_barang, sum(stok) as total_stok FROM `persediaans` WHERE rak_id = ? GROUP BY rak_id', [$raks[$i]->id_rak]);

        //     $data[$i]['id_rak'] = $raks[$i]->id_rak;
        //     $data[$i]['nomor_rak'] = $raks[$i]->nomor_rak;
        //     if(count($query) == 0){
        //         $data[$i]['jumlah_barang'] = 0;
        //         $data[$i]['total_stok'] = 0;
        //     }else{
        //         $data[$i]['jumlah_barang'] = count($query);
        //         $data[$i]['total_stok'] = 0;
        //         for($j = 0; $j < count($query); $j++) {
        //             $data[$i]['total_stok'] += $query[$j]->total_stok;
        //         }
        //     }
        // }
        // // return view('rak.index', ['data' => $data]);
        // // print_r($data);

        $raks=Rak::orderBy('nomor_rak', 'ASC')->withCount('persediaan')->get();;

        // DB::table('yourtablename')->select(DB::raw('(price * quantity) as totalPriceQuantity'))->get();

        // $data = DB::table("persediaans")->sum('stok');
        // print_r($data);

        // $query->withCount([
        //     'activity AS paid_sum' => function ($query) {
        //                 $query->select(DB::raw("SUM(amount_total) as paidsum"))->where('status', 'paid');
        //             }
        //         ]);
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

        // $request->validate([
        //     'nomor_rak'    => 'required|string|unique:raks,nomor_rak',
        // ]);

        // Rak::create([
        //     'nomor_rak'    => $request->nomor_rak,
        // ]);

        // $data['id'] = Rak::first()->id;
        // $data['nomor_rak'] = $request->nomor_rak;
        // $data['jumlah_produk'] = 0;
        // $data['total_stok'] = 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rak $id_rak
     * @return \Illuminate\Http\Response
     */
    public function show($id_rak, $id_persediaan)
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
        // $request->validate([
        //     'nomor_rak'    => 'required|string|unique:raks,nomor_rak,'.$request->id.'',
        // ]);

        // Rak::where('id', $id)->update([
        //     'nomor_rak'    => $request->nomor_rak,
        // ]);
        
        // $data['id'] = $id;
        // $data['nomor_rak'] = $request->nomor_rak;
        // $data['jumlah_produk'] = 0;
        // $data['total_stok'] = 0;


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
