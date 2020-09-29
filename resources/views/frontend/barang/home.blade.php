@extends('frontend.layout.front')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-12 mb-5">
            <img src="{{ url('images/logo.png') }}" class="rounded mx-auto d-block" width="300" alt="">
        </div> --}}
        @foreach($barangs as $barang)
        <div class="col-md-4">
            <div class="card">
              <img src="{{ asset('storage/barangs/' . $barang->gambar) }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $barang-> nama_barang }}</h5>
                <p class="card-text">
                    <strong>Harga :</strong> Rp. {{ number_format($barang -> harga_jual)}} <br>
                    <strong>Stok :</strong> {{ ($barang -> persediaan_count)}} <br>
                    <strong>Stok :</strong> 	
                    @foreach($barang-> persediaan as $itemp)
                      
                        {{ $itemp->stok}}
                                                
                    @endforeach 
                    
                    <br>
                    <hr>
                    <strong>Keterangan :</strong> <br>
                    {{ $barang-> keterangan }} 
                </p>
                <a href="{{ url('pesan') }}/{{ $barang->id_barang }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Pesan</a>
              </div>
            </div> 
        </div>
        @endforeach

        {{-- @foreach ($persediaan as $item)
        <div class="card-body">
            <h5 class="card-title">{{ $item->stok }}</h5>
           </div>
        @endforeach --}}
    </div>
</div>
@endsection
