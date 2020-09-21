<?php

namespace App\Http\Controllers\Frontend;
use App\Barang;
use App\Pesanan;
use App\User;
use App\PesananDetail;
use Auth;
use Alert;
use App\DetailPenjualan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
    	$pesanans = DetailPenjualan::where('user_id', Auth::user()->id)->where('status', '!=',0)->get();

    	return view('history.index', compact('pesanans'));
    }

    public function detail($id)
    {
    	// $pesanan = Pesanan::where('id', $id)->first();
    	// $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

     	// return view('history.detail', compact('pesanan','pesanan_details'));
    }
}
