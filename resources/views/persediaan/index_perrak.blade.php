@extends('layouts.admin')

@section('content')
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
    
</style>
<section class="content"> 
    <div class="card" style="margin: 30px;">
       
        <div class="row row-cols-1 row-cols-md-3 flex-row">
            @foreach ($raks as $item)
            <div class="col-md-3 mb-4 px-3">
                <div class="card">
                    <div class="card-header right"> Nomor Rak
                            
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><a href="/persediaan/{{ $item->id_rak }}"> {{ $item->nomor_rak }}</a></h4>
                        <br>
                        <hr>
                        <p class="card-text">{{ $item->persediaan_count }}</p>
                        <hr>
                        <div>
                            <a href="{{ route('rak.create')}}" class="btn btn-primary btn-sm fa fa-file"> Tambah Barang</a>
                            <a href="{{ route('rak.edit',$item->id_rak)}}" class="btn  text-right btn-success btn-sm fa fa-edit"> Edit </a>
                            <form action="{{ route('rak.destroy', $item->id_rak) }}" method="POST" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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