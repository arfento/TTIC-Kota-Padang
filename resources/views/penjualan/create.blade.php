@extends('layouts.admin')


@section('top')
<!-- DataTables -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
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
                  <input class="form-control" name="nomor_faktur">
                </div>
              </div>
              <div class="col col-4" style="padding: 20px; border-left: 1px solid #eaeaea">
                <div class="form-group">
                  <span class="label text-dark">Tanggal</span>
                  {!! Form::text('tanggal', old('tanggal',
                  Carbon\Carbon::today()->format('Y-m-d')),['class'=>'form-control date-picker', 'readonly']) !!}
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
                  <th >Nama Barang</th>
                  <th>Jumlah Barang</th>
                  <th>Harga</th>
                  <th>Total</th>
                  <th><a href="#" class="addRow"><i class="glyphicon glyphicon-plus"></i></a></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select class="form-control barang_id" name="barang_id">
                      @foreach ($barang as $item)
                              <option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>
                      @endforeach
                    </select>
                  </td>
                 
                  <td><input type="text" name="jumlah" class="form-control jumlah" required=""></td>
                  <td><input type="text" name="harga_satuan" class="form-control harga_satuan"></td>
                  <td><input type="text" name="total" class="form-control total"></td>
                  <td><input type="text" name="jumlah_bayar" class="form-control jumlah_bayar"></td>
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
                  <td><b class="totalall"></b> </td>
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

            {{-- <table> --}}
              {{-- <thead>
                <tr>
                  <th class="nomor">No</th>
                  <th style="width: 200px;">Barang</th>
                  <th style="width: 50px;text-align: center;">Jumlah</th>
                  <th style="width: 100px">Harga</th>
                  <th style="width: 120px">Subtotal</th>
                  <th style="width: 30px"></th>
                </tr>
              </thead> --}}
              {{-- <tbody> --}}
                {{-- <tr v-for="(item, index) in penjualan.detail_penjualan" :key="index"> --}}
                  {{-- <td class="nomor">1</td> --}}
                  {{-- <td v-if="cekKuantitas[index]" style="min-width: 150px;"><a --}}
                      {{-- style="font-weight: 500">{{ item.nama_produk }}Nama --}}
                      {{-- Barang</a><span>{{ item.jenis_produk }} kode barang | <span --}}
                        {{-- style="color: #ff4949">{{ item.stok }}00 stok tersedia</span></span></td> --}}
                  {{-- <td v-else style="min-width: 150px;"><a style="font-weight: 500">{{ item.nama_produk }}</a><span>{{ item.kode_produk }}
                    | {{ item.stok }} {{ item.satuan_produk.toLowerCase() }} tersedia</span></td> --}}
                  {{-- <td><input --}}
                      {{-- v-model="item.kuantitas" @input="cekStok(item.kuantitas, item.stok, item.nama_produk, index)" :class="{'has-error': cekKuantitas[index] || item.kuantitas == '' || item.kuantitas == 0}" --}}
                      {{-- type="number" class="input" min="1" --}}
                      {{-- style="width: 50px;text-align: center;padding: 0;margin: 0 auto"></td> --}}
                  {{-- <td>{{ item.harga_satuan | rupiah }} </td> --}}
                  {{-- <td>{{ item.kuantitas * item.harga_satuan | rupiah }}</td> --}}
                  {{-- <td><a @click.prevent="removeCart(index)" href=""><i class="icon-hapus error" --}}
                        {{-- title="hapus"></i></a></td> --}}
                {{-- </tr> --}}
              {{-- </tbody> --}}
            {{-- </table> --}}
          </div>
        </div>
        {{-- <div class="col col-4" style="width: 30%;padding-left: 10px"> --}}
          {{-- <div class="card right"> --}}
            {{-- <div class="total"> --}}
              {{-- <span class="label">Total</span> --}}
              {{-- <span class="value">{{ getTotal | rupiah }}111110101</span> --}}
            {{-- </div> --}}
            {{-- <div class="bayar"> --}}
              {{-- <span class="label">Bayar</span> --}}
              {{-- <input v-model="penjualan.jumlah_bayar" type="number" @keyup.enter="bayar" --}}
                {{-- placeholder="0"> --}}

            {{-- </div> --}}
          {{-- </div> --}}
          {{-- <button --}}
            {{-- v-if="penjualan.detail_penjualan.length > 0 && penjualan.jumlah_bayar > 0 && cekKuantitas.length == 0 && getTotal > 0" --}}
            {{-- class="button button-bayar" type="button" @click="bayar">Bayar</button> --}}


          {{-- <button v-else class="button button-bayar nonaktif" type="button" style="cursor: default">Bayar</button> --}}
        {{-- </div> --}}
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
        });
        function totalall(){
            var totalall=0;
            $('.total').each(function(i,e){
                var total=$(this).val()-0;
            totalall +=total;
        });
        $('.totalall').html("Rp. "+totalall);   
        }
        $('.addRow').on('click',function(){
            addRow();
        });
        function addRow()
        {
            var tr='<tr>'+
            '<td>'+
              '<select class="form-control" name="barang_id">'+
                      '@foreach ($barang as $item)'+
                      '<option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>'+
                      '@endforeach'+
                    '</select>'+
            // <input type="text" name="barang_id" class="form-control">
            '</td>'+
          
            '<td><input type="text" name="jumlah" class="form-control jumlah"></td>'+
            '<td><input type="text" name="harga_satuan" class="form-control harga_satuan"></td>'+
            ' <td><input type="text" name="total" class="form-control total"></td>'+
            ' <td><input type="text" name="jumlah_bayar" class="form-control jumlah_bayar"></td>'+
            '<td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>'+
            '</tr>';
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