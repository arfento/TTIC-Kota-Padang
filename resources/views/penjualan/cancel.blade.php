@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Cancel Order #{{ $order->nomor_faktur }}</h2>
                </div>
                <div class="card-body">
                    @include('themes.ezone.partials.flash', ['$errors' => $errors])
                    {!! Form::model($order, ['url' => ['penjualan/cancel', $order->id_penjualan], 'method' => 'PUT']) !!}
                    {!! Form::hidden('id_penjualan') !!}
                    <div class="form-group">
                        {!! Form::label('cancellation_note', 'Cancellation Note') !!}
                        {!! Form::textarea('cancellation_note', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-footer pt-5 border-top">
                        <button type="submit" class="btn btn-primary btn-default">Cancel the Order</button>
                        <a href="{{ url('penjualan') }}" class="btn btn-secondary btn-default">Back</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>  
        </div>
        <div class="col-lg-6">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>Detail Order</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Billing Address</p>
                            <address>
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                                <br> {{ $order->customer_address1 }}
                                <br> {{ $order->customer_address2 }}
                                <br> Email: {{ $order->customer_email }}
                                <br> Phone: {{ $order->customer_phone }}
                                <br> Postcode: {{ $order->customer_postcode }}
                            </address>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
                            <address>
                                ID: <span class="text-dark">#{{ $order->nomor_faktur }}</span>
                                <br> {{ ($order->tanggal) }}
                                <br> Status: {{ $order->status }}
                                <br> Payment Status: {{ $order->payment_status }}
                                <br> Shipped by: {{ $order->shipping_service_name }}
                            </address>
                        </div>
                    </div>
                    <table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Berat Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->detailPenjualan as $item)
                                <tr>
                                    <td>{{ $item->barang->nama_barang }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ ($item->total) }}</td>
                                    <td>{{ $item->berat_barang }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Order item not found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row justify-content-end">
                        <div class="col-lg-5 col-xl-6 col-xl-3 ml-sm-auto">
                            <ul class="list-unstyled mt-4">
                                <li class="mid pb-3 text-dark">Subtotal
                                    <span class="d-inline-block float-right text-default">{{ ($order->total) }}</span>
                                </li>

                                <li class="mid pb-3 text-dark">Shipping Cost
                                    <span class="d-inline-block float-right text-default">{{ ($order->shipping_cost) }}</span>
                                </li>
                                <li class="pb-3 text-dark">Total
                                    <span class="d-inline-block float-right">{{ ($order->grand_total) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection