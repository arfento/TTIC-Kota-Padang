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
            <div class="header">
                <a href="{{ route('penjualan.create')}}" class="btn btn-primary btn-sm" >Tambah Penjualan</a>
                <a {{-- href="{{ route('exportPDF.categoriesAll') }}" --}} class="btn btn-danger btn-sm">Export PDF</a>
                <a {{-- href="{{ route('exportExcel.categoriesAll') }}" --}} class="btn btn-success btn-sm">Export Excel</a>
            </div>
            <hr>
            @include('notifikasi')
            
            <table class="table table-bordered table-striped" id="users-table">
                <thead>
                    <tr>
                        <th width="10">Nomor</th>
                        <th>Nomor Faktur</th>
                        <th>Total</th>
                        <th>Nama Pembeli</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>
                            {{ $item-> nomor_faktur }}
                            <br>
                            <span style="font-size: 12px; font-weight: normal"> {{($item->tanggal) }}</span>
                        </td>
                        <td>
                            Rp. {{ number_format($item-> grand_total) }}
                            <br>
                            {{ $item-> detailPenjualan_count }}
                        </td>
                        <td>{{ $item-> customer_full_name }}</td>
                        <td>{{ $item-> status }}</td>
                        <td>{{ $item->payment_status }}</td>
                        
                        
                        <td>
                            <a href="{{ route('penjualan.show',$item->id_penjualan) }}" class="btn btn-info btn-sm fa fa-list-alt" > show </a>
                            <a href="{{ route('penjualan.edit',$item->id_penjualan)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                            <form action="{{ route('penjualan.destroy', $item->id_penjualan) }}" method="POST" style="display: inline">
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
