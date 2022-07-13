@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Shipments</h2>
                    </div>
                    <div class="card-body">
                        @include('themes.ezone.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Total Qty</th>
                                <th>Total Weight (gram)</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($shipments as $shipment)
                                    <tr>    
                                        <td>
                                            {{ $shipment->penjualan->nomor_faktur }}<br>
                                            <span style="font-size: 12px; font-weight: normal"> {{($shipment->penjualan->tanggal) }}</span>
                                        </td>
                                        <td>{{ $shipment->penjualan->customer_full_name }}</td>
                                        <td>
                                            {{ $shipment->status }}
                                            <br>
                                            <span style="font-size: 12px; font-weight: normal"> {{ $shipment->shipped_at }}</span>
                                        </td>
                                        <td>{{ $shipment->total_qty }}</td>
                                        <td>{{ ($shipment->total_weight) }}</td>
                                        <td>
                                            {{-- @can('edit_orders') --}}
                                                <a href="{{ url('penjualan/'. $shipment->penjualan->id_penjualan) }}" class="btn btn-info btn-sm">show</a>
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
                        {{ $shipments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection