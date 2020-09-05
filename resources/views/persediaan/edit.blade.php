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
    <div class="card-header">Edit Persediaan</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('persediaan.update', $persediaan->id_persediaan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nomor Rak</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="rak_id">
                @foreach ($rak as $item)
                <option value="{{ $item->id_rak }}"> {{ $item->nomor_rak }} </option>
                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
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
          <label class="col-md-2 col-form-label text-md-right">Stok</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="stok" class="form-control" value="{{ $persediaan->stok }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Tanggal Kadaluarsa</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input class="form-control" type="date" name="tanggal_kadaluarsa" value="{{ $persediaan->tanggal_kadaluarsa }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>  
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Update data</button>
            <a href="{{ route('persediaan.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</section>
@endsection