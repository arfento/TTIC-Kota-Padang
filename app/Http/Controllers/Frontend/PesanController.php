<?php

namespace App\Http\Controllers\Frontend;
use Alert;
use App\User;
use App\Barang;
use App\DetailPenjualan;
use App\Pesanan;
use App\Penjualan;
use Carbon\Carbon;
use App\Persediaan;
use App\PesananDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id_barang)
    {
    	$barang = Barang::where('id_barang', $id_barang)->first();

    	return view('frontend.pesan.index', compact('barang'));
    }

    
    public function getPembelianID($id_persediaan)
    {
        $data = Persediaan::where('id_persediaan', $id_persediaan)->first();
        return $data->id_persediaan;
    }


    public function pesan(Request $request, $id_barang)
    {	
        $barang = Barang::where('id_barang', $id_barang)->first();
        $tanggal = Carbon::now();
        $persediaan = Persediaan::all();

        //validasi apakah melebihi stok
/*     	if($request->jumlah > $barang->stok)
    	{
    		return redirect('pesan/'.$id_barang);
    	}
 */
    	//cek validasi
    /* 	$cek_pesanan = Penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	//simpan ke database pesanan
    	if(empty($cek_pesanan))
    	{
    		$penjualan = new Penjualan();
	    	$penjualan->user_id = Auth::user()->id;
	    	$penjualan->tanggal = $tanggal;
	    	$penjualan->status = 0;
	    	$penjualan->jumlah_bayar = 0;
            $penjualan->kode = mt_rand(100, 999);
	    	$penjualan->save();
    	} */
    	

    	//simpan ke database pesanan detail
    	$pesanan_baru = Penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();

    	//cek pesanan detail
    	$cek_pesanan_detail = DetailPenjualan::where('barang_id', $barang->id_barang)->where('penjualan_id', $pesanan_baru->id_penjualan)->first();
    	if(empty($cek_pesanan_detail))
    	{
    		$pesanan_detail = new DetailPenjualan();
	    	$pesanan_detail->barang_id = $barang->id_barang;
	    	$pesanan_detail->pesanan_id = $pesanan_baru->id_penjualan;
	    	$pesanan_detail->jumlah = $request->jumlah;
	    	// $pesanan_detail->jumlah_harga = $barang->harga*$request->jumlah;
	    	$pesanan_detail->save();
    	}else 
    	{
    		$pesanan_detail = DetailPenjualan::where('barang_id', $barang->id_barang)->where('penjualan_id', $pesanan_baru->id_penjualan)->first();

    		$pesanan_detail->jumlah = $pesanan_detail->jumlah+$request->jumlah_pesan;

    		//harga sekarang
    		$harga_pesanan_detail_baru = $barang->harga*$request->jumlah_pesan;
	    	$pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga+$harga_pesanan_detail_baru;
	    	$pesanan_detail->update();
    	}

    	//jumlah total
    	$pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	$pesanan->jumlah_harga = $pesanan->jumlah_harga+$barang->harga*$request->jumlah_pesan;
    	$pesanan->update();
    	
        Alert::success('Pesanan Sukses Masuk Keranjang', 'Success');
    	return redirect('check-out');

    }

    public function check_out()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
 	$pesanan_details = [];
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        }
        
        return view('pesan.check_out', compact('pesanan', 'pesanan_details'));
    }

    public function delete($id)
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first();

        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();


        $pesanan_detail->delete();

        Alert::error('Pesanan Sukses Dihapus', 'Hapus');
        return redirect('check-out');
    }

    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->alamat))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        if(empty($user->nohp))
        {
            Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();

        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
            $barang->stok = $barang->stok-$pesanan_detail->jumlah;
            $barang->update();
        }



        Alert::success('Pesanan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$pesanan_id);

    }

    
}
