@extends('layouts.admin')



@section('content')
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
</style>

<!-- /.content-header -->

<section class="content"> 
    
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
