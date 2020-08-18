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
        <div class="card-header">Satuan Pemmbelian</div>

        <div class="card-body">
            <a href="{{ route('satuanpembelian.create')}}" class="btn btn-info btn-sm">Tambah Satuan Pembelian</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Satuan</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($satuanpembelian as $item)
                    <tr>
                        <td>{{ $item->id_satuan_pembelian}}</td>
                        <td>{{ $item->satuan }}</td>
                        
                        <td><a href="{{ route('satuanpembelian.edit',$item->id_satuan_pembelian)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        {!! Form::open(['route'=>['satuanpembelian.destroy',$item->id_satuan_pembelian],'method'=>'DELETE']) !!}
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
