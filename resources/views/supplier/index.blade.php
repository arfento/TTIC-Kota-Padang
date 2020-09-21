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
        <div class="card-header">Table Supplier</div>
        <div class="card-body">
            <div class="header">
                <a href="{{ route('supplier.create')}}" class="btn btn-primary btn-sm" >Tambah Supplier</a>
                <a {{-- href="{{ route('exportPDF.categoriesAll') }}" --}} class="btn btn-danger btn-sm">Export PDF</a>
                <a {{-- href="{{ route('exportExcel.categoriesAll') }}" --}} class="btn btn-success btn-sm">Export Excel</a>
            </div>
            <hr>
            @include('notifikasi')
            <table class="table table-bordered" id="supplier-table">
                <thead>
                    <tr>
                        <th scope="col">Nomor</th>
                        <th>Nama Supplier</th>
                        <th>Email Supplier</th>
                        <th>Nomor Telepon Supplier</th>
                        <th>Jumlah Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_supplier }}</td>
                        <td>{{ $item->email_supplier }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>{{ $item->pembelian_count }}</td>
                        <td>
                            <a href="{{ route('supplier.edit',$item->id_supplier)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                            <form action="{{ route('supplier.destroy', $item->id_supplier) }}" method="POST" style="display: inline">
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

@section('bot')
<script>
    $(function () {
        $("#supplier-table").DataTable({
            "responsive": true,
            "autoWidth": true,
        });
        
    });
</script>
@endsection


