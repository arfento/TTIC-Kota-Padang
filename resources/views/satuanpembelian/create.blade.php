@extends('layouts.admin')

@section('content')
<style type="text/css">
.card-header {
  background-color: #27c8f9;
}
</style>
<div class="content-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">Tambah Satuan Pembelian</div>
      <div class="card-body">
        @include('validasi')
        {!! Form::open(['route'=>'satuanpembelian.store','methode'=>'POST']) !!} 
    
       <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Satuan Pembelian</label>
        <div class="col-md-6">
          {!! Form::text('satuan',null,['class'=>'form-control']) !!}
        </div>
      </div>
      
      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
          <button type="submit" class="btn btn-info">Tambah data</button>
          <a href="{{ route('satuanpembelian.index') }}" class="btn btn-danger">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection