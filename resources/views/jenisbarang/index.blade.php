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
{{-- {{$dataTable->table()}} --}}
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
</style>

<section class="content">
    <div class="card">
        <div class="card-header">Jenis Barang</div>
        
        <div class="card-body">
            <a href="{{ route('jenisbarang.create')}}" class="btn btn-info btn-sm">Tambah Jenis Barang</a><hr>
            @include('notifikasi')
            
            <table class="table table-bordered" id="jenisbarang-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis Barang</th>
                        <th>Count</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($jenisbarang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->barang_count }}</td>
                        
                        <td><a href="{{ route('jenisbarang.edit',$item->id_jenis_barang)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('jenisbarang.destroy', $item->id_jenis_barang) }}" method="POST">
                            @csrf
                            @method('delete')
                            
                            <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php $no++; ?>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
</section>
@endsection

@section('bot')
<script>
    $(function () {
        $("#jenisbarang-table").DataTable({
            "responsive": true,
            "autoWidth": true,
        });
        
    });
</script>
@endsection
