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
    <div class="card-header">Edit Supplier</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nama Supplier</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="nama_supplier" class="form-control" value="{{ $supplier->nama_supplier }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Email Supplier</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="email_supplier" class="form-control" value="{{ $supplier->email_supplier }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nomor Telepon Supplier</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="telepon" class="form-control" value="{{ $supplier->telepon }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Alamat Supplier</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="alamat_supplier" class="form-control" value="{{ $supplier->alamat_supplier }}">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Update data</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
        
      </form>
    </div>
  </div>
</section>
@endsection