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
        <div class="card-header">Rak Barang</div>

        <div class="card-body">
            <a href="{{ route('rak.create')}}" class="btn btn-info btn-sm">Tambah Rak Barang</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Rak</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($rak as $item)
                    <tr>
                        <td>{{ $item->id_rak}}</td>
                        <td>{{ $item->nomor_rak }}</td>
                        
                        <td><a href="{{ route('rak.edit',$item->id_rak)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        {!! Form::open(['route'=>['rak.destroy',$item->id_rak],'method'=>'DELETE']) !!}
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
