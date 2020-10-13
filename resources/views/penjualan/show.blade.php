@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
		<div class="d-flex justify-content-between">
			<h2 class="text-dark font-weight-medium">Order ID #{{ $order->nomor_faktur }}</h2>
			<div class="btn-group">
				<button class="btn btn-sm btn-secondary">
					<i class="mdi mdi-content-save"></i> Save</button>
				<button class="btn btn-sm btn-secondary">
					<i class="mdi mdi-printer"></i> Print</button>
			</div>
		</div>
		<div class="row pt-5">
			<div class="col-xl-4 col-lg-4">
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
			<div class="col-xl-4 col-lg-4">
				<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Shipment Address</p>
				<address>
					{{ $order->shipment->first_name }} {{ $order->shipment->last_name }}
					<br> {{ $order->shipment->address1 }}
					<br> {{ $order->shipment->address2 }}
					<br> Email: {{ $order->shipment->email }}
					<br> Phone: {{ $order->shipment->phone }}
					<br> Postcode: {{ $order->shipment->postcode }}
				</address>
			</div>
			<div class="col-xl-4 col-lg-4">
				<p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Details</p>
				<address>
					ID: <span class="text-dark">#{{ $order->nomor_faktur }}</span>
					<br> {{ ($order->tanggal) }}
					<br> Status: {{ $order->status }} {{ $order->isCancelled() ? '('. ($order->cancelled_at) .')' : null}}
					@if ($order->isCancelled())
						<br> Cancellation Note : {{ $order->cancellation_note}}
					@endif
					<br> Payment Status: {{ $order->payment_status }}
					<br> Shipped by: {{ $order->shipping_service_name }}
				</address>
			</div>
		</div>
		<table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
			<thead>
				<tr>
					<th>#</th>
					<th>Item</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Unit Cost</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				@forelse ($order->detailPenjualan as $item)
                <tr>
                    <td>
                        <img width="100px" height="100px" class="profile-user-img img-fluid" src="{{ asset('storage/barangs/' . $item->barang->gambar) }}" >
                    </td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{!! ($item->attributes) !!}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ ($item->harga_satuan) }}</td>
                    <td>{{ ($item->jumlah * $item->harga_satuan ) }}</td>
                </tr>
				@empty
					<tr>
						<td colspan="6">Order item not found!</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		<div class="row justify-content-end">
			<div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">
				<ul class="list-unstyled mt-4">
					<li class="mid pb-3 text-dark">Subtotal
						<span class="d-inline-block float-right text-default">{{ ($order->total) }}</span>
					</li>
					{{-- <li class="mid pb-3 text-dark">Tax(10%)
						<span class="d-inline-block float-right text-default">{{ ($order->tax_amount) }}</span>
					</li> --}}
					<li class="mid pb-3 text-dark">Shipping Cost
						<span class="d-inline-block float-right text-default">{{ ($order->shipping_cost) }}</span>
					</li>
					<li class="pb-3 text-dark">Total
						<span class="d-inline-block float-right">{{ ($order->grand_total) }}</span>
					</li>
				</ul>
				@if (!$order->trashed())
					@if ($order->isPaid() && $order->isConfirmed())
						<a href="{{ url('shipments/'. $order->shipment->id_shipment .'/edit')}}" class="btn btn-block mt-2 btn-lg btn-primary btn-pill"> Procced to Shipment</a>
					@endif

					@if (in_array($order->status, [\App\Penjualan::CREATED, \App\Penjualan::CONFIRMED]))
						<a href="{{ url('penjualan/'. $order->id_penjualan .'/cancel')}}" class="btn btn-block mt-2 btn-lg btn-warning btn-pill"> Cancel</a>
					@endif

					@if ($order->isDelivered())
						<a href="#" class="btn btn-block mt-2 btn-lg btn-success btn-pill" onclick="event.preventDefault();
						document.getElementById('complete-form-{{ $order->id_penjualan }}').submit();"> Mark as Completed</a>

						{!! Form::open(['url' => 'penjualan/complete/'. $order->id_penjualan, 'id' => 'complete-form-'. $order->id_penjualan, 'style' => 'display:none']) !!}
						{!! Form::close() !!}
					@endif

					@if (!in_array($order->status, [\App\Penjualan::DELIVERED, \App\Penjualan::COMPLETED]))
						<a href="#" class="btn btn-block mt-2 btn-lg btn-secondary btn-pill delete" order-id="{{ $order->id_penjualan }}"> Remove</a>

						{!! Form::open(['url' => 'penjualan/'. $order->id_penjualan, 'class' => 'delete', 'id' => 'delete-form-'. $order->id_penjualan, 'style' => 'display:none']) !!}
						{!! Form::hidden('_method', 'DELETE') !!}
						{!! Form::close() !!}
					@endif
				@else
					<a href="{{ url('penjualan/restore/'. $order->id_penjualan)}}" class="btn btn-block mt-2 btn-lg btn-outline-secondary btn-pill restore"> Restore</a>
					<a href="#" class="btn btn-block mt-2 btn-lg btn-danger btn-pill delete" order-id="{{ $order->id_penjualan }}"> Remove Permanently</a>

					{!! Form::open(['url' => 'penjualan/'. $order->id_penjualan, 'class' => 'delete', 'id' => 'delete-form-'. $order->id_penjualan, 'style' => 'display:none']) !!}
					{!! Form::hidden('_method', 'DELETE') !!}
					{!! Form::close() !!}
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
