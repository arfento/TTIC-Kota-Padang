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
        <div class="card-header">Detail Pembelian</div>
        
        <div class="card-body">
            <div class="header">
                <a href="{{ route('detailpembelian.create')}}" class="btn btn-primary btn-sm" >Tambah Detail Pembelian</a>
                {{-- <a href="{{ route('exportPDF.categoriesAll') }}" class="btn btn-danger btn-sm">Export PDF</a> --}}
                {{-- <a href="{{ route('exportExcel.categoriesAll') }}" class="btn btn-success btn-sm">Export Excel</a> --}}
            </div>
            <hr>
            @include('notifikasi')
            
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Nama Barang</th>
                        <th>Pembelian</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        {{-- <th>Tanggal Kadaluarsa</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailpembelian as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>{{ $item-> barang -> nama_barang }}</td>
                        <td>{{ $item-> pembelian -> nomor_faktur }}</td>
                        <td>{{ $item-> jumlah }}</td>
                        <td>{{ $item-> harga_satuan }}</td>
                        {{-- <td>{{ $item-> tanggal_kadaluarsa }}</td> --}}
                        
                        <td>
                            <a href="{{ route('detailpembelian.edit',$item->id_detail_pembelian)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                            <form action="{{ route('detailpembelian.destroy', $item->id_detail_pembelian) }}" method="POST" style="display: inline">
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
