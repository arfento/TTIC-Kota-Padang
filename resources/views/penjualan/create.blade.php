@extends('layouts.admin')


@section('top')
<!-- DataTables -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet"
  href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<style type="text/css">
  .card-header {
    background-color: #27c8f9;
  }
</style>
<section class="content">
  <div class="content penjualan">
    @include('validasi')
    <form action="{{ route('penjualan.store') }}" method="POST">
      @csrf
      {{-- <div class="search-area">
              <div class="search-form">
                  <i class="icon-cari"></i>
                  <input v-model="searchText" type="text" class="input" placeholder="cari produk...">
              </div>
              <span v-if="loading" class="info">Sedang mengambil data...</span>
              <span v-else-if="filteredProduks.length > 0" class="info">Menampilkan {{ filteredProduks.length }}
      produk</span>
      <span v-else class="info">Produk '{{ searchText }}' tidak tersedia</span>
      <loading v-if="loading"></loading>
      <ul v-else class="search-results">
        <li v-for="item in filteredProduks" :key="item.id">
          <div class="list" @click="addCart(item)">
            <div class="product">
              <span class="name">{{ item.nama_produk }}</span>
              <span class="detail">{{ item.kode_produk }} | {{ item.stok }} {{ item.satuan.toLowerCase() }}
                tersedia</span>
            </div>
            <div class="add">
              <i class="icon-tambah"></i>
            </div>
          </div>
        </li>
      </ul>
      </div> --}}
      <div class="container">
        {{-- <div class="topbar">
                      <div class="page-title">
                          <a class="logo" @click="$router.go(-1)"><div class="back"><span class="icon-expand"></span></div><img class="img" src="/images/logo2.png" alt="Logo"/></a>
                      </div>
                      <div class="user-area">
                          <div class="user">
                              <div class="name">{{ user }}</div>
        <span class="role">{{ role }}</span>
        </div>
        <img class="img" src="/images/avatar.png">
        </div>
        </div> --}}
        <div class="row">
          <div class="col col-12">
            <div class="main-content row">
              <div class="col" style="width: 70%;padding-right: 10px">
                <div class="card row header" style="padding:0px; margin-bottom: 20px">
                  <div class="row">

                    <div class="col col-4" style="padding: 20px">
                      <div class="form-group">

                        <span class="label text-dark">Nomor Faktur</span>
                        <input class="form-control" name="nomor_faktur" value="{{ $random }}" readonly>
                      </div>
                    </div>

                    <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                      <div class="form-group">
                        <span class="label text-dark">Tanggal</span>
                        {!! Form::text('tanggal', old('tanggal',
                        Carbon\Carbon::today()->format('d-m-Y')),['class'=>'form-control date-picker', 'readonly']) !!}
                        {{-- <span class="value" value="tanggal">{{ date('d-m-Y', strtotime($penjualan -> tanggal)) }}</span>
                        --}}
                      </div>
                    </div>
                    <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                      <div class="form-group">
                        <span class="label text-dark">Petugas</span><br>
                        <span class="form-control">{{ Auth::user()->name }}</span>
                        <input class="form-control" name="user_id" value="{{ Auth::user()->id }}" hidden>
                      </div>
                    </div>

                   
                  </div>
                </div>
                <div class="card row body" style="padding:0px; margin-bottom: 20px">

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th><a href="#" class="addRow"><i class="glyphicon glyphicon-plus"></i></a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class="form-control barang_id" name="barang_id[0]">
                            @foreach ($barang as $item)
                            <option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>
                            @endforeach
                          </select>
                        </td>

                        <td><input type="text" name="jumlah[0]" class="form-control jumlah" required=""></td>
                        <td><input type="text" name="harga_satuan[0]" class="form-control harga_satuan"></td>
                        <td><input type="text" name="total[0]" class="form-control total"></td>
                        <td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>
                      </tr>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        {{-- <td style="border: none"></td> --}}
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td>Total</td>
                        <td>
                          <b class="totalall"></b>
                          {{-- <input class="totalall" name="totalall" --}}
                        </td>
                        <td>
                          <input type="submit" name="" value="Submit" class="btn btn-success">
                          {{-- <div class="col-md-6 offset-md-2">
                                  <button type="submit" class="btn btn-info">Tambah data</button> --}}
                          <a href="{{ route('pembelian.index') }}" class="btn btn-danger">Kembali</a>
                          {{-- </div> --}}
                        </td>

                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        {{-- <flash></flash> --}}
        {{-- <kembalianmodal></kembalianmodal> --}}
    </form>
  </div>

  <script type="text/javascript">
    $('tbody').delegate('.jumlah,.harga_satuan','keyup',function(){
            var tr=$(this).parent().parent();
            var jumlah=tr.find('.jumlah').val();
            var harga_satuan=tr.find('.harga_satuan').val();
            var total=(jumlah*harga_satuan);
            tr.find('.total').val(total);
            totalall();
            jumlahbayar()
        });
        function totalall(){
            var totalall=0;
            $('.total').each(function(i,e){
                var total=$(this).val()-0;
            totalall +=total;
        });
        $('.totalall').html("Rp. "+totalall);   
        };
        function jumlahbayar(){
            var jumlahbayar=0;
            $('.total').each(function(i,e){
                var total=$(this).val()-0;
                jumlahbayar +=total;
        });
        $('.jumlahbayar').html("Rp. "+jumlahbayar);   
        }
        $('.addRow').on('click',function(){
            addRow();
        });
        var index = 1;
        var no = 2;
        function addRow()
        {
            var tr='<tr>'+
            '<td>'+
              '<select class="form-control" name="barang_id[' + index + ']">'+
                      '@foreach ($barang as $item)'+
                      '<option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>'+
                      '@endforeach'+
                    '</select>'+
            // <input type="text" name="barang_id" class="form-control">
            '</td>'+
          
            '<td><input type="text" name="jumlah[' + index + ']" class="form-control jumlah"></td>'+
            '<td><input type="text" name="harga_satuan[' + index + ']" class="form-control harga_satuan"></td>'+
            ' <td><input type="text" name="total[' + index + ']" class="form-control total"></td>'+
            '<td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>'+
            '</tr>';
            index++;
            $('tbody').append(tr);
        };
        $('.remove').live('click',function(){
             var last=$('tbody tr').length;
             if(last==1){
                 alert("you can not remove last row");
             }
             else{
                  $(this).parent().parent().remove();
             }
         
         });
  </script>

</section>

@endsection