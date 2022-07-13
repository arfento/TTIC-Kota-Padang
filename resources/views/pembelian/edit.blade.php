@extends('layouts.admin')


@section('top')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection

@section('content')
<style type="text/css">
  .card-header {
    background-color: #27c8f9;
  }
</style>
<section class="content">
  <div class="card">
    <div class="card-header">Edit Pembelian</div>
    <div class="card-body">
      @include('validasi')
      <form action="{{ route('pembelian.update', $pembelian->id_pembelian) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col col-12">
            <div class="card custom" style="padding: 25px 40px">
              <span class="title " style="margin-bottom: 10px">
                <font size="5">Edit Pembelian Barang</font>
              </span>

              <div class="row">
                <div class="col-md-3" style="padding-right: 10px">
                  <div class="form-group">
                    <label class="label text-dark">Nama Supplier</label>
                    <select class="form-control" name="supplier_id">
                      @foreach ($supplier as $item)
                      @if ($item->id_supplier == $pembelian -> supplier_id)
                        <option value="{{ $pembelian->supplier_id }}" selected="selected"> {{ $pembelian->supplier->nama_supplier }} </option>
                        @else
                        <option value="{{ $item->id_supplier }}"> {{ $item->nama_supplier }} </option>
                      @endif
                      @endforeach
                     </select>
                    {{-- <search-select v-model="pembelian.vendor_id" :options="vendor" placeholder="Pilih Vendor"></search-select> --}}
                    {{-- <span v-if="errors.vendor_id" class="help error">{{ errors.vendor_id[] }}</span> --}}
                  </div>
                </div>

                <div class="col-md-3" style="padding: 0px 10px">
                  <div class="form-group">
                    <label class="label text-dark">Nomor Faktur</label>
                    <input type="text" name="nomor_faktur" class="form-control" value="{{ $pembelian->nomor_faktur }}"
                      readonly>
                    {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                    {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[] }}</span> --}}
                  </div>
                </div>
                <div class="col-md-3" style="padding: 0px 10px" hidden>
                  <div class="form-group">
                    <label class="label text-dark">Nama Petugas</label>
                    <input type="text" name="user_id" class="form-control" value="{{ Auth::user()->id }}">
                    {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                    {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[] }}</span> --}}
                  </div>
                </div>
                <div class="col-md-3" style="padding-left: 10px">
                  <div class="form-group">
                    <label class="label text-dark">Tanggal Pembelian</label>
                    <input class="form-control" type="date" name="tanggal_pembelian" value="{{ $pembelian->tanggal_pembelian }}" readonly>
                    {{-- <input v-model="pembelian.tanggal" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" class="input" @change="checkForm('tanggal')"> --}}
                    {{-- <span v-if="errors.tanggal" class="help error">{{ errors.tanggal[] }}</span> --}}
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
                  @foreach ($pembelian -> detailPembelian as $item)
                  <tr>
                    <td>
                      <select class="form-control" name="barang_id[]">
                        @foreach ($barang as $bitem)
                            @if ($item->barang_id == $bitem ->id_barang)
                            <option value="{{ $item-> barang_id }}" selected="selected"> {{ $item-> barang -> nama_barang }} </option>
                            @else
                            <option value="{{ $bitem-> id_barang }}"> {{ $bitem-> nama_barang }} </option>
                        @endif
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="form-control" name="rak_id[]">
                         @foreach($item -> barang-> persediaan as $itemp)
                        @endforeach 
                        @foreach ($rak as $ritem)
                       
                            @if ($itemp->rak_id == $ritem ->id_rak)
                            <option value="{{ $itemp-> rak_id }}" selected="selected"> {{ $itemp-> rak -> nomor_rak }} </option>
                            @else
                            <option value="{{ $ritem-> id_rak }}"> {{ $ritem-> nomor_rak }} </option>
                        @endif
                        @endforeach
                        {{-- @foreach($item -> barang-> persediaan as $itemp)
                        @endforeach --}}
                        {{-- <span> {{ $itemp-> rak -> nomor_rak }} </span> --}}


                        {{-- @if ($persediaan -> rak ->rak_id == $item->id_rak) --}}
                        {{-- <option value="{{ $itemp-> rak ->rak_id }}" selected="selected">
                        {{ $itemp-> rak -> nomor_rak }} --}}
                        {{-- </option> --}}

                        {{-- @else --}}
                        {{-- <option value="{{ $itemp-> rak -> id_rak }}">{{ $itemp-> rak -> nomor_rak }}</option> --}}
                        {{-- @endif --}}

                      </select>
                    </td>
                    <td><input type="text" name="jumlah[]" class="form-control jumlah" required=""
                        value=" {{ $item->jumlah}}">
                      {{-- @foreach($pembelian-> detailPembelian as $itemp)

                      value=" {{ $itemp->jumlah}}"

                      @endforeach> --}}
                    </td>
                    <td><input type="text" name="harga_satuan[]" class="form-control harga_satuan"
                        value=" {{ $item->harga_satuan}}">
                      {{-- @foreach($pembelian-> detailpembelian as $itemp)

                      value="{{ $itemp->harga_satuan}}"

                      @endforeach> --}}

                    </td>
                    <td><input type="text" name="total[]" class="form-control total"  readonly></td>
                    <td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    {{-- <td style="border: none"></td> --}}
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td>Total</td>
                    <td><b class="totalall" value="{{ $pembelian->total }}"></b> </td>
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
            {{-- <div class="form-group row">
              <label class="col-md-2 col-form-label text-md-right">Nomor Faktur</label>
              <div class="col-md-6">
                <div class="col-md-6">
                  <input type="text" name="nomor_faktur" class="form-control" value="{{ $pembelian->nomor_faktur }}">
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
            @if ($item->id == $item ->user_id)
            <option value="{{ $item->id }}" selected="selected"> {{ $item->name }} </option>
            @else
            <option value="{{ $item->id }}"> {{ $item->name }} </option>
            @endif

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
            @if ($item->id_supplier == $item ->supplier_id)
            <option value="{{ $item->id_supplier }}" selected="selected"> {{ $item->nama_supplier }} </option>
            @else
            <option value="{{ $item->id_supplier }}"> {{ $item->nama_supplier }} </option>
            @endif

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
          <input class="form-control" type="date" name="tanggal_pembelian" value="{{ $pembelian->tanggal_pembelian }}">
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-2 col-form-label text-md-right">Total</label>
      <div class="col-md-6">
        <div class="col-md-6">
          <input type="text" name="total" class="form-control" value="{{ $pembelian->total }}">
        </div>
        <div class="clearfix"></div>
      </div>
    </div>


    <div class="form-group row mb-0">
      <div class="col-md-6 offset-md-2">
        <button type="submit" class="btn btn-info">Update data</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-danger">Kembali</a>
      </div>
    </div> --}}

    </form>
  </div>
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
          var index = 1;
          var no = 2;
          function addRow()
          {
              var tr='<tr>'+
              '<td>'+
                '<select class="form-control" name="barang_id[]">'+
                        '@foreach ($barang as $item)'+
                        '<option value="{{ $item-> id_barang }}"> {{ $item-> nama_barang }} </option>'+
                        '@endforeach'+
                      '</select>'+
              // <input type="text" name="barang_id" class="form-control">
              '</td>'+
              '<td>'+
                '<select class="form-control" name="rak_id[]">'+
                        '@foreach ($rak as $item)'+
                        '<option value="{{ $item-> id_rak }}"> {{ $item-> nomor_rak }} </option>'+
                        '@endforeach'+
                      '</select>'+
              '</td>'+
              '<td><input type="text" name="jumlah[]" class="form-control jumlah">'+
                // '@foreach($pembelian-> detailPembelian as $itemp)'+
                //       'value=" {{ $itemp->jumlah}}"'+
                                               
                //       '@endforeach>'+
              '</td>'+
              '<td><input type="text" name="harga_satuan[]" class="form-control harga_satuan">'+
                // '@foreach($pembelian-> detailPembelian as $itemp)'+
                //       'value=" {{ $itemp->harga_satuan}}"'+
                                               
                //       '@endforeach>'+
              '</td>'+
              ' <td><input type="text" name="total[]" class="form-control total" readonly></td>'+
              '<td><a href="#" class="btn btn-danger remove"><i class="glyphicon glyphicon-remove"></i></a></td>'+
              '</tr>';
              index++;
              $('tbody').append(tr);
          };
          $('.remove').live('click',function(){
               var last=$('tbody tr').length;
               if(last==1){
                    index = 0;
                    alert("you can not remove last row");
               }
               else{
                    index--;
                    $(this).parent().parent().remove();
               }
           
           });

          
  
  </script>
</section>
@endsection