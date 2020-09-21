<?php

namespace App\Http\Controllers;

use App\Barang;
use App\JenisBarang;
use App\SatuanPembelian;
use App\SatuanPenjualan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $barang=Barang::all();
        return view('barang.index',compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $satuanpembelian= SatuanPembelian::all();
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
        $validatedData = $request->validate([
            'kode_barang'=>'required',
            'nama_barang'=>'required',
            'jenis_barang_id'=>'required',
            'satuan_pembelian_id'=>'required',
            'isi'=>'required',
            'satuan_penjualan_id'=>'required',
            'harga_beli'=>'required',
            'harga_jual'=>'required',
            'gambar'=>'required',
            'keterangan'=>'required',
        ]);
        
       if($request->file('gambar')) {
            $gambarName = time().'.'.$request->gambar->extension();
            $request->gambar->Storage::putFileAs('public',$gambarName);
            $validatedData['gambar'] = $gambarName;
        }

        // dd($validatedData);
      

        Barang::create($validatedData);

        return redirect()->route('barang.index')->with('success','Data Berhasil Dimasukkan');
        //


       /*  $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg'
        ]);
		
        //JIKA FOLDERNYA BELUM ADA
        if (!File::isDirectory($this->path)) {
            //MAKA FOLDER TERSEBUT AKAN DIBUAT
            File::makeDirectory($this->path);
        }
		
        //MENGAMBIL FILE IMAGE DARI FORM
        $file = $request->file('image');
        //MEMBUAT NAME FILE DARI GABUNGAN TIMESTAMP DAN UNIQID()
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //UPLOAD ORIGINAN FILE (BELUM DIUBAH DIMENSINYA)
        Image::make($file)->save($this->path . '/' . $fileName);
		
        //LOOPING ARRAY DIMENSI YANG DI-INGINKAN
        //YANG TELAH DIDEFINISIKAN PADA CONSTRUCTOR
        foreach ($this->dimensions as $row) {
            //MEMBUAT CANVAS IMAGE SEBESAR DIMENSI YANG ADA DI DALAM ARRAY 
            $canvas = Image::canvas($row, $row);
            //RESIZE IMAGE SESUAI DIMENSI YANG ADA DIDALAM ARRAY 
            //DENGAN MEMPERTAHANKAN RATIO
            $resizeImage  = Image::make($file)->resize($row, $row, function($constraint) {
                $constraint->aspectRatio();
            });
			
            //CEK JIKA FOLDERNYA BELUM ADA
            if (!File::isDirectory($this->path . '/' . $row)) {
                //MAKA BUAT FOLDER DENGAN NAMA DIMENSI
                File::makeDirectory($this->path . '/' . $row);
            }
        	
            //MEMASUKAN IMAGE YANG TELAH DIRESIZE KE DALAM CANVAS
            $canvas->insert($resizeImage, 'center');
            //SIMPAN IMAGE KE DALAM MASING-MASING FOLDER (DIMENSI)
            $canvas->save($this->path . '/' . $row . '/' . $fileName);
        }
        
        //SIMPAN DATA IMAGE YANG TELAH DI-UPLOAD
        Image_uploaded::create([
            'name' => $fileName,
            'dimensions' => implode('|', $this->dimensions),
            'path' => $this->path
        ]);
        return redirect()->back()->with(['success' => 'Gambar Telah Di-upload']); */


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
        $satuanpembelian= SatuanPembelian::all();
        $satuanpenjualan = SatuanPenjualan::all();
        $jenisbarang = JenisBarang::all();
        $barang=Barang::findOrFail($id_barang);
        return view('barang.edit',compact('barang', 'satuanpembelian', 'satuanpenjualan', 'jenisbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_barang)
    {
        
        $validatedData = $request->validate([
            'kode_barang'=>'required',
            'nama_barang'=>'required',
            'jenis_barang_id'=>'required',
            'satuan_pembelian_id'=>'required',
            'isi'=>'required',
            'satuan_penjualan_id'=>'required',
            'harga_beli'=>'required',
            'harga_jual'=>'required',
            'keterangan'=>'required',
            'gambar'=>'required|image',
        ]);

        if($request->file('gambar')) {
            if($request->file('gambar')->isValid()) {
                $gambarName = time().'.'.$request->gambar->extension();
                $request->gambar-> Storage::putFileAs('public/gambar',$gambarName);
                $validatedData['gambar'] = $gambarName;
                Storage::disk('public')->delete($id_barang->gambar);
            }
        }

        $id_barang->update($validatedData);



        // $input = $request->all();

        // $barang = Barang::findOrFail($id_barang);
        
        // $input['gambar'] = $barang->gambar;
        // if ($request->hasFile('gambar')){
        //     if (!$barang->gambar == NULL){
        //         unlink(public_path($barang->gambar));
        //     }
        //     $input['gambar'] = '/upload/barangs/'.str::slug($input['nama_barang'], '-').'.'.$request->gambar->getClientOriginalExtension();
        //     $request->gambar->move(public_path('/upload/barangs/'), $input['gambar']);
        // }
      

        // $barang->update($input);

        return redirect()->route('barang.index')->with('success','Data Berhasil Diupdate');
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
        $barang=Barang::find($id_barang);
        // if (!$barang->gambar == NULL){
        //     unlink(public_path($barang->gambar));
        // }

        $barang->delete();
        return redirect()->route('barang.index')->with('success','Data Berhasil Dihapus');
        //
    }
}
