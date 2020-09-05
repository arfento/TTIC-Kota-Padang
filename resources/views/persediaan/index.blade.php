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
        <div class="card-header">Persediaan</div>

        <div class="card-body">
            <a href="{{ route('persediaan.create')}}" class="btn btn-info btn-sm">Tambah Persediaan</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nomor Rak</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($persediaan as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>{{ $item-> rak -> nomor_rak }}</td>
                        <td>{{ $item-> barang -> nama_barang }}</td>
                        <td>{{ $item-> stok }}</td>
                        <td>{{ $item-> tanggal_kadaluarsa }}</td>
                        
                        
                        <td><a href="{{ route('persediaan.edit',$item->id_persediaan)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('persediaan.destroy', $item->id_persediaan) }}" method="POST">
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
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable();
    });
</script>
@endpush
