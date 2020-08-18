@extends('layouts.app')

@section('content')
<style type="text/css">
.card-header {
  background-color: #27c8f9;
}
</style>
<div class="content-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">Edit Jenis Barang</div>
      <div class="card-body">
        @include('validasi')
        {!! Form::model($jenisbarang,['route'=>['jenisbarang.update',$jenisbarang->id_jenis_barang],'method'=>'PUT']) !!} 

       <div class="form-group row">
        <label class="col-md-2 col-form-label text-md-right">Jenis Barang</label>
        <div class="col-md-6">
          {!! Form::text('jenis',null,['class'=>'form-control']) !!}
        </div>
      </div>

     

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
          <button type="submit" class="btn btn-info">Update data</button>
          <a href="{{ route('jenisbarang.index') }}" class="btn btn-danger">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection