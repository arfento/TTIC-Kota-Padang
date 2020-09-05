@extends('layouts.admin')

@section('content')
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
    
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header"><i class="fas fa-database"> Data Persediaan Per Rak </i></div>
                
                <div class="card-body">
                    
                    <a href="{{ route('rak.create')}}" class="btn btn-info btn-sm">Tambah Rak</a><hr>
                    
                    <table class="table table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th> No </i></th>
                                <th> Nomor Rak </i></th>
                                <th> Jumlah Barang </i></th>
                                <th> Total Stok </i></th>
                                <th> Edit </th>
                                <th> Hapus </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @foreach ($raks as $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->nomor_rak}}</td>
                                <td>{{ $item->persediaan_count}}</td>
                                <td>Total</td>
                                <td>
                                    <a {{-- href="/absensi/{{ $item->id }}/create" --}} class="btn btn-success btn-sm fas fa-plus-square">
                                        Absensi</a>
                                        {{-- <a href="{{ route('absensi.create')}}" class="btn btn-info btn-sm"><i
                                            class="fas fa-plus-square"> Tambah Data Absensi</i></a>
                                            <hr> --}}
                                        </td>
                                        <td>
                                            <a href="{{ route('persediaan.show',$item->id_rak)}}" class="btn btn-primary btn-sm fas fa-eye"> Detail</a>
                                        </td>
                                        
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            
                            {{-- {!! $absensi->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        
        @push('scripts')
        <script>
            $(function() {
                $('#users-table').DataTable();
            });
        </script>
        @endpush