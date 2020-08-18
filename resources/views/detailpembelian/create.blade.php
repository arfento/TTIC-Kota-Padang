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
    <div class="card-header">Tambah Detail Pembelian</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('detailpembelian.store') }}" method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nama Barang</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="barang_id">
                @foreach ($barang as $item)
                <option value="{{ $item->id_barang }}"> {{ $item->nama_barang }} </option>
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
              <select class="form-control" name="pembelian_id">
                @foreach ($pembelian as $item)
                <option value="{{ $item->id_pembelian }}"> {{ $item->nomor_faktur }} </option>
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
              <input type="text" name="jumlah" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Harga Satuan</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="harga_satuan" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Tanggal Kadaluarsa</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input class="form-control" type="date" name="tanggal_kadaluarsa">
             </div>
            <div class="clearfix"></div>
          </div>
        </div>
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Tambah data</button>
            <a href="{{ route('detailpembelian.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection