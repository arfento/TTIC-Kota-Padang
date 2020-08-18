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
<div class="content">
    <div class="card">
      <div class="card-header">Edit Satuan Pembelian</div>
      <div class="card-body">
        <form action="{{ route('satuanpembelian.update', $satuanpembelian->id_satuan_pembelian) }}" method="POST">
          @csrf
          @method('PUT')
       <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Satuan Pembelian</label>
        <div class="col-md-6">
          <div class="col-md-6">
            <input type="text" name="satuan" class="form-control" value="{{ $satuanpembelian->satuan }}">
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

     

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
          <button type="submit" class="btn btn-info">Update data</button>
          <a href="{{ route('satuanpembelian.index') }}" class="btn btn-danger">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection