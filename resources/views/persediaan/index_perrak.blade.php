@extends('layouts.admin')

@section('content')
<style type="text/css">
    .card-header {
        background-color: #27c8f9;
    }
</style>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rak persediaan </h3>
        </div>
        <div class="card-body">

            <div class="header">
                <a href="{{ route('rak.create')}}" class="btn btn-primary btn-sm fa fa-file"> Tambah Rak</a>
            </div>
            <hr>
            {{-- <div class="row row-cols-1 row-cols-md-3 flex-row">
                @foreach ($raks as $item)
                <div class="col-md-3 mb-4 px-3">
                    <div class="card">
                        <div class="card-header right" style="background-color: #27c8f9;"> Nomor Rak
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><a href="/persediaan/{{ $item->id_rak }}">
            {{ $item->nomor_rak }}</a>
            </h4>
            <br>
            <hr>
            <p class="card-text">{{ $item->persediaan_count }}</p>
            <hr>
            <div>
                <a href="/persediaan/{{ $item->id_rak }}" class="btn btn-info btn-sm fa fa-list-alt">
                    Detail</a>
                <a href="{{ route('rak.edit',$item->id_rak)}}" class="btn  text-right btn-success btn-sm fa fa-edit">
                    Edit
                </a>
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
    </div> --}}

    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                {{-- <th>#</th> --}}
                <th width="10%">Nomor</th>
                <th>Nomor Rak</th>
                <th>Count</th>
                <th width="30%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($raks as $item)
            <tr>
                {{-- <td> <input type="checkbox" name="delid[]" value="{{ $item -> id_satuan_pembelian}}"></td>
                --}}
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nomor_rak }}</td>
                <td>{{ $item->persediaan_count }}</td>

                <td>
                    <div>
                        <a href="/persediaan/{{ $item->id_rak }}" class="btn btn-info btn-sm fa fa-list-alt">
                            Detail</a>
                        <a href="{{ route('rak.edit',$item->id_rak)}}"
                            class="btn  text-right btn-success btn-sm fa fa-edit"> Edit </a>
                        <form action="{{ route('rak.destroy', $item->id_rak) }}" method="POST" style="display: inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
    </div>
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