@extends('layouts.admin')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Pembayaran Report</h2>
					</div>
					<div class="card-body">
						@include('themes.ezone.partials.flash')
						@include('reports.filter')
						<table class="table table-bordered table-striped">
							<thead>
								<th>Order ID</th>
								<th>Date</th>
								<th>Status</th>
								<th>Amount</th>
								<th>Gateway</th>
								<th>Payment Type</th>
								<th>Ref</th>
							</thead>
							<tbody>
								@forelse ($payments as $payment)
									<tr>    
										<td>{{ $payment->nomor_faktur }}</td>
										<td>{{ ($payment->created_at) }}</td>
										<td>{{ $payment->status }}</td>
										<td>{{ ($payment->amount) }}</td>
										<td>{{ $payment->method }}</td>
										<td>{{ $payment->payment_type }}</td>
										<td>{{ $payment->token }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="8">No records found</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection