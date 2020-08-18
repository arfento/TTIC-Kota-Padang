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
        <div class="card-header">Pembelian</div>

        <div class="card-body">
            <a href="{{ route('pembelian.create')}}" class="btn btn-info btn-sm">Tambah Pembelian</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nomor Faktur</th>
                        <th>Nama User</th>
                        <th>Nama Supplier</th>
                        <th>Tanggal Pembelian</th>
                        <th>total</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($pembelian as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>{{ $item-> nomor_faktur }}</td>
                        <td>{{ $item-> user -> name }}</td>
                        <td>{{ $item-> supplier -> nama_supplier }}</td>
                        <td>{{ $item-> tanggal_pembelian }}</td>
                        <td>{{ $item-> total }}</td>
                        
                        
                        <td><a href="{{ route('pembelian.edit',$item->id_pembelian)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('pembelian.destroy', $item->id_pembelian) }}" method="POST">
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

@push('scripts')
<script>
    $(function() {
        $('#users-table').DataTable();
    });
</script>
@endpush
