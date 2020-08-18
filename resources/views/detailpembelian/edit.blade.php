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
    <div class="card-header">Edit Satuan Pembelian</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('detailpembelian.update', $detailpembelian->id_detail_pembelian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nama Barang</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="barang_id" value="{{ $detailpembelian->barang_id }}">
                
                @foreach ($barang as $item)
                @if ($item->id_barang == $item ->barang_id)
                <option value="{{ $item->id_barang }}" selected="selected"> {{ $item->nama_barang }} </option>
                @else
                <option value="{{ $item->id_barang }}"> {{ $item->nama_barang }} </option>
                @endif
                
                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Pembelian</label>
          <div class="col-md-6">
            <div class='col-md-6'>
              <select class="form-control" name="pembelian_id" value="{{ $detailpembelian->pembelian_id }}">
                
                @foreach ($pembelian as $item)
                @if ($item->id_pembelian == $item ->pembelian_id)
                <option value="{{ $item->id_pembelian }}" selected="selected"> {{ $item->nomor_faktur }} </option>
                @else
                <option value="{{ $item->id_pembelian }}"> {{ $item->nomor_faktur }} </option>
                @endif
                
                @endforeach
              </select>
              <div class="clearfix"></div>
            </div>
          </div>
          
        </div>
        
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Jumlah</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="jumlah" class="form-control" value="{{ $detailpembelian->jumlah }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Harga Satuan</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="harga_satuan" class="form-control" value="{{ $detailpembelian->harga_satuan }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Tanggal Kadaluarsa</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input class="form-control" type="date" name="tanggal_kadaluarsa" value="{{ $detailpembelian->tanggal_kadaluarsa }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Update data</button>
            <a href="{{ route('detailpembelian.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</section>
@endsection