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
        <div class="card-header">
            <h3 class="card-title">Tabel Satuan Pembelian {{ $countbarang }}</h3>
           
            
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="header">
                <a href="{{ route('satuanpembelian.create')}}" class="btn btn-primary btn-sm" >Tambah Satuan Pembelian</a>
                <a {{-- href="{{ route('exportPDF.categoriesAll') }}" --}} class="btn btn-danger btn-sm">Export PDF</a>
                <a {{-- href="{{ route('exportExcel.categoriesAll') }}" --}} class="btn btn-success btn-sm">Export Excel</a>
            </div>
            <hr>
            @include('notifikasi')
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th width="10%">Nomor</th>
                        <th>Satuan</th>
                        <th>Count</th>
                        <th width="30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($satuanpembelian as $item)
                    <tr>
                        {{-- <td> <input type="checkbox" name="delid[]" value="{{ $item -> id_satuan_pembelian}}"></td> --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ $item->barang_count }}</td>
                        
                        <td><a href="{{ route('satuanpembelian.edit',$item->id_satuan_pembelian)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a>
                            
                            <form style="display: inline" action="{{ route('satuanpembelian.destroy', $item->id_satuan_pembelian) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$item->satuan}}');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <form style="display: inline" action="{{ url('satuanpembelian/delid') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{$item->satuan}}');">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete Selected</button>
            </form> --}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    
</section>
@endsection

@section('bot')
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": true,
        });
        
    });
</script>
@endsection

