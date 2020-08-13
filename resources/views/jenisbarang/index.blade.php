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
        <div class="card-header">Jenis Barang</div>

        <div class="card-body">
            <a href="{{ route('jenisbarang.create')}}" class="btn btn-info btn-sm">Tambah Jenis Barang</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Barang</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($jenisbarang as $item)
                    <tr>
                        <td>{{ $item->id_jenis_barang}}</td>
                        <td>{{ $item->jenis }}</td>
                        
                        <td><a href="{{ route('jenisbarang.edit',$item->id_jenis_barang)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        {!! Form::open(['route'=>['jenisbarang.destroy',$item->id_jenis_barang],'method'=>'DELETE']) !!}
                        <td><button type="submit" name="submit" class="btn btn-danger btn-sm fas fa-trash-alt"> Hapus </button></td>
                        {!! Form::close() !!}   
                    </tr>
                    <?php $no++; ?>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable();
    });
</script>
@endpush
