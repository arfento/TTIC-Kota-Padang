@extends('layouts.admin')



@section('content')
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
</style>

<!-- /.content-header -->

<section class="content"> 
    <div class="row row-cols-1 row-cols-md-3">
        @foreach ($raks as $item)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header">Nomor Rak</div>
                <div class="card-body">
                    <h6 class="card-title">{{ $item->nomor_rak }}</h6>
                    <br>
                    <hr>
                    <p class="card-text">asda</p>
                    <a class="btn btn-primary">Button</a>
                    <span  class="info" style="color: #0065ff">{{-- {{ item.jumlah_produk }} produk, {{ item.total_stok }} stok --}}</span>
                    <span v-else class="info">rak sedang kosong</span>
                </div>
            </div>
            
        </div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-header">Rak Barang</div>
        
        <div class="card-body">
            <a href="{{ route('rak.create')}}" class="btn btn-info btn-sm">Tambah Rak Barang</a><hr>
            @include('notifikasi')
            
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th>Nomor Rak</th>
                        <th scope="col" colspan="2" class="text-center w-25">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($raks as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nomor_rak }}</td>
                        
                        <td><a href="{{ route('rak.edit', $item->id_rak )}}" class="btn btn-success btn-sm fa fa-edit"> Edit </a></td>
                        <td><form action="{{ route('rak.destroy', $item->id_rak) }}" method="POST">
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
