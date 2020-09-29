<?php

namespace App\Http\Controllers;

use App\Barang;
use App\JenisBarang;
use App\SatuanPembelian;
use App\SatuanPenjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public $path;
    // public $dimensions;

    // public function __construct()
    // {
    //     //DEFINISIKAN PATH
    //     $this->path = storage_path('app/public/images');
    //     //DEFINISIKAN DIMENSI
    //     $this->dimensions = ['245', '300', '500'];
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $satuanpembelian = SatuanPembelian::all();
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
        //     $validatedData = $request->validate([
        //         'kode_barang'=>'required',
        //         'nama_barang'=>'required',
        //         'jenis_barang_id'=>'required',
        //         'satuan_pembelian_id'=>'required',
        //         'isi'=>'required',
        //         'satuan_penjualan_id'=>'required',
        //         'harga_beli'=>'required',
        //         'harga_jual'=>'required',
        //         'gambar'=>'required',
        //         'keterangan'=>'required',
        //     ]);

        //    if($request->file('gambar')) {
        //         $gambarName = time().'.'.$request->gambar->extension();
        //         $request->gambar->Storage::putFileAs('public',$gambarName);
        //         $validatedData['gambar'] = $gambarName;
        //     }

        //     // dd($validatedData);


        //     Barang::create($validatedData);

        // return redirect()->route('barang.index')->with('success','Data Berhasil Dimasukkan');
        //     //


        $this->validate($request, [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jenis_barang_id' => 'required',
            'satuan_pembelian_id' => 'required',
            'isi' => 'required',
            'satuan_penjualan_id' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan' => 'nullable',
        ]);


        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->storeAs('public/barangs', $filename);

            $barangs = Barang::create([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'jenis_barang_id' => $request->jenis_barang_id,
                'satuan_pembelian_id' => $request->satuan_pembelian_id,
                'isi' => $request->isi,
                'satuan_penjualan_id' => $request->satuan_penjualan_id,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'gambar' => $filename,
                'keterangan' => $request->keterangan
            ]);
            // dd($barangs);
            return redirect(route('barang.index'))->with('success', 'Data Berhasil Dimasukkan');
        }


        //input foto
        $barangs = new Barang();

        // $barangs->id_barang = $request->input('id_barang');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $extension = $file->getClientOriginalName();
            $filename = time() . '.' . $extension;
            $file->move(public_path('/uploads/gambar'), $filename);
            $barangs->gambar = $filename;
        } else {
            return $request;
            $barangs->gambar = '';
        }

        $barangs->kode_barang = $request->input('kode_barang');
        $barangs->nama_barang = $request->input('nama_barang');
        $barangs->jenis_barang_id = $request->input('jenis_barang_id');
        $barangs->satuan_pembelian_id = $request->input('satuan_pembelian_id');
        $barangs->isi = $request->input('isi');
        $barangs->satuan_penjualan_id = $request->input('satuan_penjualan_id');
        $barangs->harga_beli = $request->input('harga_beli');
        $barangs->harga_jual = $request->input('harga_jual');
        $barangs->keterangan = $request->input('keterangan');

        $request->save();

        // alihkan halaman ke halaman pegawai
        return redirect('/barang');
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
        $satuanpembelian = SatuanPembelian::all();
        $satuanpenjualan = SatuanPenjualan::all();
        $jenisbarang = JenisBarang::all();
        $barang = Barang::findOrFail($id_barang);
        return view('barang.edit', compact('barang', 'satuanpembelian', 'satuanpenjualan', 'jenisbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {

        // dd($barang);
        $validatedData = $request->validate([
            'kode_barang'         => 'required',
            'nama_barang'         => 'required',
            'jenis_barang_id'     => 'required',
            'satuan_pembelian_id' => 'required',
            'isi'                 => 'required',
            'satuan_penjualan_id' => 'required',
            'harga_beli'          => 'required',
            'harga_jual'          => 'required',
            'gambar'              => 'nullable',
            'keterangan'          => 'nullable',
        ]);
        

        // $file = $request->file('gambar');
        // $extension = $file->getClientOriginalName();
        // $filename = time() . '.' . $extension;
        // $file->storeAs('public/barangs', $filename);

        // $validatedData['gambar'] = $filename;
        // if (file_exists(public_path($filename =  $file->getClientOriginalName()))) 
        // {
        //     File::delete(storage_path('app/public/barangs/' . $barang->gambar));
        // };
        // if($request->gambar) {
        //     if($request->file('gambar')->isValid()) {
        //         $imgName = time().'.'.$request->gambar->extension();
        //         $request->gambar->storeAs('public/barangs',$imgName);
        //         $validatedData['gambar'] = $imgName;
        //         // Storage::disk('public/barangs')->delete($barang->img);
        //     }
        // }

        if ($request->file('gambar')) {
            if ($request->file('gambar')->isValid()) {
                // $file = $request->file('gambar');
                // $extension = $file->getClientOriginalName();
                // $filename = time() . '.' . $extension;
                // $file->storeAs('public/barangs', $filename);
                // File::delete(storage_path('app/public/barangs/' . $barangs->gambar));

                $filename = time() . '.' . $request->gambar->extension();
                $request->gambar->storeAs('public/barangs', $filename);
                $validatedData['gambar'] = $filename;
                // dd('barangs');
        
                
                File::delete(storage_path('app/public/barangs/' . $barang->gambar));
                // Storage::disk('public')->delete($barberman->img);
            }
        }
        $barang ->update($validatedData);

        /*  $this->validate($request,[
            'kode_barang'=>'required',
            'nama_barang'=>'required',
            'jenis_barang_id'=>'required',
            'satuan_pembelian_id'=>'required',
            'isi'=>'required',
            'satuan_penjualan_id'=>'required',
            'harga_beli'=>'required',
            'harga_jual'=>'required',
            // 'gambar'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan'=>'nullable',
            ]);     */

        /* $barangs = Barang::find($id_barang);
            // $barangs = $request->all();
            // dd($barangs);

            // $filename = $barangs->gambar;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $extension = $file->getClientOriginalName();
                $filename = time() . '.' . $extension;
                $file->storeAs('public/barangs', $filename);
                File::delete(storage_path('app/public/barangs/' . $barangs->gambar));
                // $barangs->gambar = $filename;

                $barangs->update([
                    'kode_barang' => $request->kode_barang,
                    'nama_barang' => $request->nama_barang,
                    'jenis_barang_id' => $request->jenis_barang_id,
                    'satuan_pembelian_id' => $request->satuan_pembelian_id,
                    'isi' => $request->isi,
                    'satuan_penjualan_id' => $request->satuan_penjualan_id,
                    'harga_beli' => $request->harga_beli,
                    'harga_jual' => $request->harga_jual,
                    'gambar' => $filename,
                    'keterangan' => $request->keterangan
                ]);
               
                return redirect()->route('barang.index')->with('success','Data Berhasil Diupdate');
       
            }
            $barangs->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'jenis_barang_id' => $request->jenis_barang_id,
                'satuan_pembelian_id' => $request->satuan_pembelian_id,
                'isi' => $request->isi,
                'satuan_penjualan_id' => $request->satuan_penjualan_id,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'gambar' => $request->gambar,
                'keterangan' => $request->keterangan
                
            ]); */

        return redirect()->route('barang.index')->with('success', 'Data Berhasil Diupdate');
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
        $barang = Barang::find($id_barang);
        File::delete(storage_path('app/public/barangs/' . $barang->gambar));
        // if (!$barang->gambar == NULL){
        //     // unlink(public_path('uploads/gambar'),($barang->gambar));
        //     unlink(public_path()  . $barang->gambar );
        // }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data Berhasil Dihapus');
        //
    }
}
