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
    <div class="card-header">Edit Penjualan</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nomor Faktur</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="nomor_faktur" class="form-control" value="{{ $penjualan->nomor_faktur }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Tanggal</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input class="form-control" type="date" name="tanggal" value="{{ $penjualan->tanggal }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Jumlah Bayar</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="jumlah_bayar" class="form-control" value="{{ $penjualan->jumlah_bayar }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Total</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="total" class="form-control" value="{{ $penjualan->total }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nama User</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <select class="form-control" name="user_id">
                @foreach ($user as $item)
                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                @endforeach
              </select>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      
       
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Update data</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</section>
@endsection