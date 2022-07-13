@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Trashed Orders</h2>
                    </div>
                    <div class="card-body">
                        @include('themes.ezone.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Order ID</th>
                                <th>Grand Total</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>    
                                        <td>
                                            {{ $order->nomor_faktur }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{($order->tanggal) }}</span>
                                        </td>
                                        <td>{{($order->grand_total) }}</td>
                                        <td>
                                            {{ $order->customer_full_name }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $order->customer_email }}</span>
                                        </td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->payment_status }}</td>
                                        <td>
                                            {{-- @can('edit_orders') --}}
                                                <a href="{{ route('penjualan.show', $order->id_penjualan) }}" class="btn btn-info btn-sm">show</a>
                                            {{-- @endcan --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection