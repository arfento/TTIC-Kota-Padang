@extends('layouts.admin')


@section('top')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<style type="text/css">
  .card-header {
    background-color: #27c8f9;
  }
</style>
<section class="content">
  <div class="card">
    <div class="card-header">Edit Barang</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Kode Barang</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="kode_barang" class="form-control" value="{{ $barang->kode_barang }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nama Barang</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Jenis Barang</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="jenis_barang_id">
                @foreach ($jenisbarang as $item)
                @if ($item->id_jenis_barang == $item ->jenis_barang_id)
                  <option value="{{ $item->id_jenis_barang }}" selected="selected"> {{ $item->jenis }} </option>
                  @else
                  <option value="{{ $item->id_jenis_barang }}"> {{ $item->jenis }} </option>
                @endif

                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Satuan Pembelian</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="satuan_pembelian_id">
               
                @foreach ($satuanpembelian as $item)
                @if ($item->id_satuan_pembelian == $item ->satuan_pembelian_id)
                  <option value="{{ $item->id_satuan_pembelian }}" selected="selected"> {{ $item->satuan }} </option>
                  @else
                  <option value="{{ $item->id_satuan_pembelian }}"> {{ $item->satuan }} </option>
                @endif

                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Isi</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="isi" class="form-control" value="{{ $barang->isi }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Satuan Penjualan</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="satuan_penjualan_id">
                @foreach ($satuanpenjualan as $item)
                @if ($item->id_satuan_penjualan == $item ->satuan_penjualan_id)
                  <option value="{{ $item->id_satuan_penjualan }}" selected="selected"> {{ $item->satuan }} </option>
                  @else
                  <option value="{{ $item->id_satuan_penjualan }}"> {{ $item->satuan }} </option>
                @endif

                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Harga Beli</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="harga_beli" class="form-control" value="{{ $barang->harga_beli }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Harga Jual</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="harga_jual" class="form-control" value="{{ $barang->harga_jual }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Gambar</label>
          <div class="col-md-6">
            <div class="col-md-6">
                <input type="file" class="form-control-file @error('gambar') is-invalid @enderror" id="gambar" name="gambar" onchange="loadPreview(this);" value="{{ $barang->gambar }}" required autofocus>
                <span class="help-block with-errors"></span>
                <label for="gambar"></label>
                <img id="preview_img" src="" class="" width="200" height="200" src="{{ url('/upload/barangs/'.$item->gambar)}}">
        
            </div>
            <div class="clearfix"></div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Keterangan</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="keterangan" class="form-control" value="{{ $barang->keterangan }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        


        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Update data</button>
            <a href="{{ route('barang.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</section>
@endsection
<script>
  function loadPreview(input, id) {
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
 
        reader.onload = function (e) {
            $(id)
                    .attr('src', e.target.result)
                    .width(200)
                    .height(200);
        };
 
        reader.readAsDataURL(input.files[0]);
    }
 }
</script>