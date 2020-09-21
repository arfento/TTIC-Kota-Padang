@extends('layouts.admin')

@section('content')
<div class="content pembelian">
    <div class="container">
        <topbar :title="title"></topbar>
        <loading v-if="loading"></loading>
        <div v-else class="row">
            <div class="col col-11">
                <div class="card custom detail">
                    <div style="display:flex; justify-content: space-between">
                        <span class="title" style="margin-bottom: 20px;display: block;">Nomor Faktur: {{ pembelian.nomor_faktur }} ({{ pembelian.detail_pembelian_count }})</span>
                        <i class="icon-cetak success"></i>
                    </div>
                    <div class="row">
                        <div class="col col-5" style="padding-right: 10px">
                            <span>Nama Vendor</span>
                            <span class="value">{{ pembelian.nama_vendor }}</span>
                        </div>
                        <div class="col col-4" style="padding: 0px 10px">
                            <span>Tanggal Pembelian</span>
                            <span class="value">{{ pembelian.tanggal }}</span>
                        </div>
                        <div class="col col-3" style="padding-left: 10px">
                            <span>Petugas</span>
                            <span class="value">{{ pembelian.nama_user }}</span>
                        </div>
                    </div>
                </div>
                <div class="card" style="padding: 25px 40px 40px">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="">Produk</th>
                                <th style="width: 70px">Kuantitas</th>
                                <th style="width: 175px">Harga</th>
                                <th style="width: 175px">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in detailPembelian" :key="item.id">
                                <td class="nomor" style="text-align:center">{{ 1 + index }}</td>
                                <td style="min-width: 150px;"><a>{{ item.nama_produk }}</a><span>{{ item.kode_produk }}</span></td>
                                <td>{{ item.kuantitas }}</td>
                                <td>{{ item.harga_satuan | rupiah }}</td>
                                <td>{{ item.kuantitas * item.harga_satuan | rupiah }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="footer">
                        <div class="left">
                            <span>Total</span>
                            <div class="total">{{ getTotal | rupiah }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
