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
            <div class="header">
                <a href="{{ route('pembelian.create')}}" class="btn btn-primary btn-sm" >Tambah Pembelian</a>
                {{-- <a href="{{ route('exportPDF.categoriesAll') }}" class="btn btn-danger btn-sm">Export PDF</a> --}}
                {{-- <a href="{{ route('exportExcel.categoriesAll') }}" class="btn btn-success btn-sm">Export Excel</a> --}}
            </div>
            <hr>
            @include('notifikasi')
            
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nomor Faktur</th>
                        <th>Nama Supplier</th>
                        <th>Tanggal Pembelian</th>
                        <th>Jumlah Item</th>
                        <th>total</th>
                        <th>Nama Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($pembelian as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td><a href="{{ route('pembelian.show',$item->nomor_faktur)}}" style="text-blue"> {{ $item-> nomor_faktur }} </a></td>
                        <td>{{ $item-> supplier -> nama_supplier }}</td>
                        <td>{{ $item-> tanggal_pembelian }}</td>
                        <td>{{ $item-> detailPembelian_count }}</td>
                        <td>Rp. {{ number_format($item-> total) }}</td>
                        <td>{{ $item-> user -> first_name }}</td>   
                        <td>
                            <a href="{{ route('pembelian.show',$item->nomor_faktur)}}" class="btn btn-info btn-sm fa fa-list-alt"> Detail </a>
                            <a href="{{ route('pembelian.edit',$item->id_pembelian)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                            <form action="{{ route('pembelian.destroy', $item->id_pembelian) }}" method="POST" style="display: inline">
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
