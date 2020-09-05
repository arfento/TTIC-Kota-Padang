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
  
  <br>
  <div class="container">
    @include('validasi')
    <form action="{{ route('pembelian.store') }}" method="POST">
      @csrf
      <section>
        <div class="row">
          <div class="col col-12">
            <div class="card custom" style="padding: 25px 40px">
              <span class="title " style="margin-bottom: 10px"><font size="5">Pembelian Baru</font></span>

              <div class="row">
                <div class="col-md-3" style="padding-right: 10px">
                  <div class="form-group">
                    <label class="label text-dark">Nama Supplier</label>
                    <select class="form-control" name="supplier_id">
                      @foreach ($supplier as $item)
                      <option value="{{ $item->id_supplier }}"> {{ $item->nama_supplier }} </option>
                      @endforeach
                    </select>
                    {{-- <search-select v-model="pembelian.vendor_id" :options="vendor" placeholder="Pilih Vendor"></search-select> --}}
                    {{-- <span v-if="errors.vendor_id" class="help error">{{ errors.vendor_id[0] }}</span> --}}
                  </div>
                </div>
                
                <div class="col-md-3" style="padding: 0px 10px">
                  <div class="form-group">
                    <label class="label text-dark">Nomor Faktur</label>
                    <input type="text" name="nomor_faktur" class="form-control">
                    {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                    {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[0] }}</span> --}}
                  </div>
                </div>
                <div class="col-md-3" style="padding: 0px 10px" hidden>
                  <div class="form-group">
                    <label class="label text-dark">Nama Petugas</label>
                    <input type="text" name="user_id" class="form-control" value="{{ Auth::user()->id }}">
                    {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                    {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[0] }}</span> --}}
                  </div>
                </div>
                <div class="col-md-3" style="padding-left: 10px">
                  <div class="form-group">
                    <label class="label text-dark">Tanggal Pembelian</label>
                    <input class="form-control" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')"
                      name="tanggal_pembelian">
                    {{-- <input v-model="pembelian.tanggal" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" class="input" @change="checkForm('tanggal')"> --}}
                    {{-- <span v-if="errors.tanggal" class="help error">{{ errors.tanggal[0] }}</span> --}}
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col col-12">
            <div class="card" style="padding: 25px 40px 40px">
           
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>Rak Barang</th>
                <th>Jumlah Barang</th>
                <th>Harga</th>
                <th>Total</th>
                <th><a href="#" class="addRow"><i class="glyphicon glyphicon-plus"></i></a></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select class="form-control" name="barang_id">
                    @foreach ($barang as $item)
                    <option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <select class="form-control" name="rak_id">
                    @foreach ($rak as $item)
                    <option value="{{ $item-> id_rak }}"> {{ $item-> nomor_rak }} </option>
                    @endforeach
                  </select>
                </td>
                <td><input type="text" name="jumlah" class="form-control jumlah" required=""></td>
                <td><input type="text" name="harga_satuan" class="form-control harga_satuan"></td>
                <td><input type="text" name="total" class="form-control total"></td>
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
        </div>

      </section>
    </form>
  </div>



  <br>
  {{-- <div class="container">
    

    
    <div class="row">
      <div class="col col-11">
        <div class="card" style="padding: 25px 40px 40px">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th style="">Produk</th>
                <th style="width: 70px">Kuantitas</th>
                <th style="width: 175px">Harga</th>
                <th style="width: 175px">Subtotal</th>
                <th style="width: 30px"></th>
              </tr>
            </thead>
            <tbody>
              <tr {{-- v-for="(item, index) in pembelian.detail_pembelian" :key="index" --}}>
                {{-- <td class="nomor">{{ 1 + index }}1</td> --}}
                {{-- <td> --}}
                  {{-- <select class="form-control" name="supplier_id"> --}}
                    {{-- @foreach ($supplier as $item) --}}
                    {{-- <option value="{{ $item->id_supplier }}"> {{ $item->nama_supplier }} </option> --}}
                    {{-- @endforeach --}}
                  {{-- </select> --}}

                {{-- </td> --}}
                {{-- <td>
                  <input type="text" name="jumlah" class="form-control" style="text-align:center">
                  {{-- <input v-model="item.kuantitas" type="number" class="input disabled" min="1" style="text-align:center"> --}}
                {{-- </td> --}}

                {{-- <td>
                  <input type="text" name="harga_satuan" class="form-control">

                  {{-- <input v-model="item.harga_satuan" type="number" class="input disabled"> --}}
                </td>

                {{-- <td>
                  <input type="text-" name="total" {{-- value ="item.kuantitas * item.harga_satuan" --}}
                    {{-- class="form-control" disabled> --}}
                  {{-- <input type="text" class="input disabled" :value="item.kuantitas * item.harga_satuan | rupiah" readonly> --}}
                </td>

                {{-- <td v-if="pembelian.detail_pembelian.length > 1"><a @click.prevent="removeLine(index)" href=""><i
                      class="icon-hapus error" title="hapus"></i></a></td> --}}
              {{-- </tr> --}}
            {{-- </tbody> --}}
          {{-- </table> --}}
          {{-- <div class="footer"> --}}
            {{-- <div class="left"> --}}
              {{-- <button type="button" class="button-icon success" title="tambah" @click="newLine"><i --}}
                  {{-- class="icon-tambah"></i></button> --}}
              {{-- <button class="button" type="submit" @click="openModal('add')"><i --}}
                  {{-- class="icon-sukses"></i>Simpan</button> --}}
              {{-- <router-link :to="{ name: 'pembelian' }" class="cancel">Batal</router-link> --}}
            {{-- </div> --}}
            {{-- <div class="right"> --}}
              {{-- <span>Total</span> --}}
              {{-- <div class="total" style="-text-alignright>{{ getTotal | rupiah }} toatal </div> --}}
            {{-- </div> --}}
          {{-- </div> --}}
        {{-- </div> --}}
      {{-- </div> --}}
    {{-- </div> --}}
    
    
    
    
    
    {{-- <divclass="card"></div> --}}
                {{-- <div class="card-header">Tambah Pembelian</div>
                <div class="card-body">
                  @include('validasi')
                  <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label text-md-right">Nomor Faktur</label>
                      <div class="col-md-6">
                        <div class="col-md-6">
                          <input type="text" name="nomor_faktur" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label text-md-right">Nama User</label>
                      <div class="col-md-6">
                        <div class="col-md-6">
                          <select class="form-control" name="user_id">
                            @foreach ($user as $item)
                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label text-md-right">Nama Supplier</label>
                      <div class="col-md-6">
                        <div class='col-md-6'>
                          <select class="form-control" name="supplier_id">
                            @foreach ($supplier as $item)
                            <option value="{{ $item->id_supplier }}"> {{ $item->nama_supplier }} </option>
                            @endforeach
                          </select>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label text-md-right">Tanggal Pembelian</label>
                      <div class="col-md-6">
                        <div class="col-md-6">
                          <input class="form-control" type="date" name="tanggal_pembelian">
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2 col-form-label text-md-right">Total</label>
                      <div class="col-md-6">
                        <div class="col-md-6">
                          <input type="text" name="total" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                      </div>
                    </div>


                    <div class="form-group row mb-0">
                      <div class="col-md-6 offset-md-2">
                        <button type="submit" class="btn btn-info">Tambah data</button>
                        <a href="{{ route('pembelian.index') }}" class="btn btn-danger">Kembali</a>
                      </div>
                    </div>
                </div> --}}
     {{-- </div> --}}

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
              '<td>'+
                '<select class="form-control" name="rak_id">'+
                        '@foreach ($rak as $item)'+
                        '<option value="{{ $item-> id_rak }}"> {{ $item-> nomor_rak }} </option>'+
                        '@endforeach'+
                      '</select>'+
              '</td>'+
              '<td><input type="text" name="jumlah" class="form-control jumlah"></td>'+
              '<td><input type="text" name="harga_satuan" class="form-control harga_satuan"></td>'+
              ' <td><input type="text" name="total" class="form-control total"></td>'+
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

@section('bot')

@endsection