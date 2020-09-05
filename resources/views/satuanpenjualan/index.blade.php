@extends('layouts.admin')


@section('top')

@endsection

@section('content')
<style type="text/css">
.card-header {
  background-color: #27c8f9;
}
</style>

<section class="content">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Satuan Penjualan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <a href="{{ route('satuanpenjualan.create')}}" class="btn btn-info btn-sm">Tambah Satuan Penjualan</a><hr>
            @include('notifikasi')

            <table id="satuanpenjualan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%" >Nomor</th>
                        <th>Satuan</th>
                        <th>Count</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($satuanpenjualan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ $item->barang_count }}</td>
                        
                        <td>
                            <a href="{{ route('satuanpenjualan.edit',$item->id_satuan_penjualan)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                        
                            <form action="{{ route('satuanpenjualan.destroy', $item->id_satuan_penjualan) }}" method="POST" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    
                    
                </tbody>
                
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
   
</section>
@endsection

@section('bot')
<script>
    $(function () {
        $("#satuanpenjualan").DataTable({
            "responsive": true,
            "autoWidth": true,
        });
        
    });
</script>
@endsection
