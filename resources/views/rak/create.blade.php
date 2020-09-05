@extends('layouts.admin')

@section('content')
<style type="text/css">
  .card-header {
    background-color: #27c8f9;
  }
</style>
<section class="content">
  <div class="card">
    <div class="card-header">Tambah Rak Barang</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('rak.store') }}" method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-md-2 col-form-label text-md-right">Nomor Rak</label>
          <div class="col-md-6">
            <div class="col-md-6">
              <input type="text" name="nomor_rak" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-info">Tambah data</button>
            <a href="{{ route('rak.index') }}" class="btn btn-danger">Kembali</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection