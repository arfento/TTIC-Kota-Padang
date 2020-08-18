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
        <div class="card-header">Barang</div>

        <div class="card-body">
            <a href="{{ route('barang.create')}}" class="btn btn-info btn-sm">Tambah Barang</a><hr>
            @include('notifikasi')

            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Satuan Pembelian</th>
                        <th>isi</th>
                        <th>Satuan Penjualan</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>stok</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($barang as $item)
                    <tr>
                        <td>{{ $loop-> iteration }}</td>
                        <td>{{ $item-> kode_barang }}</td>
                        <td>{{ $item-> nama_barang }}</td>
                        <td>{{ $item-> jenis-> jenis }}</td>
                        <td>{{ $item-> satuanPembelian -> satuan }}</td>
                        <td>{{ $item-> isi }}</td>
                        <td>{{ $item-> satuanPenjualan -> satuan }}</td>
                        <td>{{ $item-> harga_beli }}</td>
                        <td>{{ $item-> harga_jual }}</td>
                        <td>{{ $item-> stok }}</td>
                        
                        <td><a href="{{ route('barang.edit',$item->id_barang)}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST">
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
