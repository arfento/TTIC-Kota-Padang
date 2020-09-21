<?php

namespace App\Http\Controllers;

use App\Barang;
use App\User;
use App\Penjualan;
use Carbon\Carbon;
use App\Persediaan;
use App\DetailPenjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
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
        
       
        $penjualan=Penjualan::all();
        // $pembelian = Pembelian::orderBy('tanggal_pembelian', 'desc')->withCount('detailPembelian')->with('supplier')->with('user')->get();
        $data = Penjualan::orderBy('tanggal', 'desc')->orderBy('nomor_faktur', 'desc')->withCount('detailPenjualan')->with('user')->get();
       
        return view('penjualan.index',compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $user= User::all();
        $penjualan = Penjualan::all();
        $detailpenjualan = DetailPenjualan::all();
        $persediaan = Persediaan::all();
        $barang = Barang::all();
        return view('penjualan.create', compact('user', 'penjualan', 'persediaan', 'barang', 'detailpenjualan'));
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
            'nomor_faktur'=>'required|string',
            'tanggal'=>'required|date',
            'jumlah_bayar'=>'required|numeric',
            'total'=>'required|numeric',
            'user_id'=>'required|string',
        ]);
        
        Penjualan::create([
            'nomor_faktur'  => $request->nomor_faktur,
            'tanggal'       => $request->tanggal,
            'jumlah_bayar'  => $request->jumlah_bayar,
            'total'         => $request->total,
            'user_id'       => $request->user_id
        ]);

        
            DetailPenjualan::create([
                'penjualan_id'      => $this->getPenjualanID($request->nomor_faktur),
                'barang_id'         => $request-> barang_id,
                'jumlah'         => $request-> jumlah,
                'harga_satuan'      => $request-> harga_satuan,
            ]);

            $barang_id = $request-> barang_id;
            $jumlah = $request-> jumlah;

            $persediaan = Persediaan::where('barang_id', $barang_id)->get();

            $n = 0;
            for($j = 0; $j < count($persediaan); $j++){
                $stok = $persediaan[$j]['stok'];
                if(($n + $stok) > $jumlah) {
                    $terkurangi = $stok - (($n + $stok) - $jumlah);
                    Persediaan::where('id_persediaan', $persediaan[$j]['id_persediaan'])->update([
                        'stok' => ($stok - $terkurangi)
                    ]);
                    break;
                }
                $n += $persediaan[$j]['stok'];
                Persediaan::where('id', $persediaan[$j]['id_persediaan'])->delete();
            }
        

        // $penjualan=Penjualan::create($request->all());
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Dimasukkan');
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
    public function edit($id_penjualan)
    {
        $user= User::all();
        $penjualan=Penjualan::findOrFail($id_penjualan);
        return view('penjualan.edit',compact('penjualan', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_penjualan)
    {
        
        $request->validate([
            'nomor_faktur'=>'required|string',
            'tanggal'=>'required|date',
            'jumlah_bayar'=>'required|numeric',
            'total'=>'required|numeric',
            'user_id'=>'required|string',
        ]);
        $penjualan=Penjualan::find($id_penjualan);
        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Diupdate');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_penjualan)
    {
        $penjualan=Penjualan::find($id_penjualan);
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success','Data Berhasil Dihapus');
        //
    }


    

    public function getPenjualanID($nomor_faktur) {
        $data = Penjualan::where('nomor_faktur', $nomor_faktur)->first();
        return $data->id_penjualan;
    }

    public function getPenjualan() {
        $data = Penjualan::getAllDataPenjualan();
        $periode = $data['periode'];
        $penjualan = Penjualan::getTotal($data['periode'],$data['data']);
        return response()->json(['periode' => $periode, 'penjualan' => $penjualan]);
    }

    public function getNomorFaktur() {
        $nextNomorFaktur = '';
        $data = Penjualan::orderBy('id_penjualan', 'desc')->first();
        $year = Carbon::today()->year;

        if(empty($data)){
            $nextNomorFaktur = 'RM'.substr($year, 2) . $this->addLeadingZero(1);
        }else{
            // $number = explode('-', $data); //RM17-00001
            $number = substr($data->nomor_faktur, 4);
            $before = $this->removeLeadingZero($number);
            $new = $this->addLeadingZero($before + 1);
            $nextNomorFaktur = 'RM'.substr($year, 2) . $new;
        }

        return response()->json($nextNomorFaktur);
    }

    public function addLeadingZero($value, $threshold = 5) {
        return sprintf('%0' . $threshold . 's', $value);
    }

    public function removeLeadingZero($value) {
        return (int)ltrim($value, '0');
    }
}
