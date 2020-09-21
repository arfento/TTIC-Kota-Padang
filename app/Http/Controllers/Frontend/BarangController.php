<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Barang;
use App\Http\Controllers\Controller;
use App\Persediaan;

class BarangController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $barangs = Barang::orderBy('nama_barang', 'Asc')->withCount('persediaan')->get();
        // $persediaan = Persediaan::join('barangs', 'persediaans.barang_id', '=', 'barangs.id_barang')
        // ->where('barangs.id_barang', $id_barang)
        // ->get();
        // $persediaan = Persediaan::all();
        return view('frontend.barang.home', compact('barangs'));
    }
}
