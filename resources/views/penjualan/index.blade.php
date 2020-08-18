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
        <div class="card-header">Penjualan</div>

        <div class="card-body">
            <a href="{{ route('penjualan.create')}}" class="btn btn-info btn-sm">Tambah Penjualan</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nomor Faktur</th>
                        <th>Tanggal</th>
                        <th>Jumlah bayar</th>
                        <th>Total</th>
                        <th>Nama User</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>{{ $item-> nomor_faktur }}</td>
                        <td>{{ $item-> tanggal }}</td>
                        <td>{{ $item-> jumlah_bayar }}</td>
                        <td>{{ $item-> total }}</td>
                        <td>{{ $item-> user -> name }}</td>
                        
                        
                        <td><a href="{{ route('penjualan.edit',$item->id_penjualan)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('penjualan.destroy', $item->id_penjualan) }}" method="POST">
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
