@extends('layouts.admin')

@section('content')
<div class="content pembelian">
    <div class="section">
        <div v-else class="row">
            <div class="col col-11">
                <div class="row">
                    <div class="col col-12">
                        <div class="card custom" style="padding: 25px 40px">
                            <span class="title " style="margin-bottom: 10px">
                                <font size="6"><b>Tampil Detail Pembelian</b></font>
                            </span>

                            <div class="row">
                                <div class="col-md-3" style="padding-right: 10px">
                                    <div class="form-group">
                                        <label class="label text-dark">Nama Supplier</label>
                                        <select class="form-control" name="supplier_id">

                                            <option value="{{ $pembelian-> supplier-> id_supplier }}">
                                                {{ $pembelian-> supplier-> nama_supplier }} </option>

                                        </select>
                                        {{-- <search-select v-model="pembelian.vendor_id" :options="vendor" placeholder="Pilih Vendor"></search-select> --}}
                                        {{-- <span v-if="errors.vendor_id" class="help error">{{ errors.vendor_id[0] }}</span>
                                        --}}
                                    </div>
                                </div>

                                <div class="col-md-3" style="padding: 0px 10px">
                                    <div class="form-group">
                                        <label class="label text-dark">Nomor Faktur</label>
                                        <input type="text" name="nomor_faktur" class="form-control"
                                            value="{{ $pembelian->nomor_faktur }}" readonly>
                                        {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                                        {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[0] }}</span>
                                        --}}
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding-left: 10px">
                                    <div class="form-group">
                                        <label class="label text-dark">Tanggal Pembelian</label>
                                        <input class="form-control" type="text" onfocus="(this.type='date')"
                                            onfocusout="(this.type='text')" name="tanggal_pembelian"
                                            value="{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)}}"
                                            disabled>
                                        {{-- <input v-model="pembelian.tanggal" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" class="input" @change="checkForm('tanggal')"> --}}
                                        {{-- <span v-if="errors.tanggal" class="help error">{{ errors.tanggal[0] }}</span>
                                        --}}
                                    </div>
                                </div>
                                <div class="col-md-3" style="padding: 0px 10px">
                                    <div class="form-group">
                                        <label class="label text-dark">Nama Petugas</label>
                                        <input type="text" name="user_id" class="form-control"
                                            value="{{ Auth::user()->id }}" hidden>
                                        <label class="form-control">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</label>
                                        {{-- <input v-model="pembelian.nomor_faktur" type="text" class="input" @change="checkForm('nomor_faktur')"> --}}
                                        {{-- <span v-if="errors.nomor_faktur" class="help error">{{ errors.nomor_faktur[0] }}</span>
                                        --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card" style="padding: 25px 40px 40px">
                    <table class="table table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Barang</th>
                                <th style="">Rak Penyimpanan Barang</th>
                            
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th style="width: 175px">Subtotal</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalall = 0; ?>
                            @foreach ($detail as $item)
                            <tr>
                                <td>{{ $loop-> iteration }}</td>
                                <td>{{ $item-> barang -> nama_barang }}</td>
                                <td style="min-width: 150px;">
                                    @foreach($item -> barang-> persediaan as $itemp)
                                    @endforeach 
                                    <span> {{ $itemp-> rak -> nomor_rak }} </span>           
                                </td>
                                <td>{{ $item-> jumlah }}</td>
                                <td>{{ $item-> harga_satuan }}</td>
                                <td>{{ $item->jumlah * $item->harga_satuan }}</td>
                                <?php $totalall = $totalall + ($item -> jumlah * $item->harga_satuan) ?>
                               
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              {{-- <td style="border: none"></td> --}}
                              <td style="border: none"></td>
                              <td style="border: none"></td>
                              <td style="border: none"></td>
                              <td style="border: none"></td>
                              <td>Total</td>
                              <td><b class="totalall">{{ $totalall }}</b> </td>
                             
          
                            </tr>
                          </tfoot>
                    </table>
                   
                    
                </div>
                

            </div>
        </div>
    </div>
</div>
@endsection