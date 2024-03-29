@extends('layouts.admin')

@section('content')
	<div class="content">
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom">
						<h2>Persediaan Report</h2>
					</div>
					<div class="card-body">
						@include('themes.ezone.partials.flash')
						{!! Form::open(['url'=> Request::path(),'method'=>'GET','class' => 'form-inline']) !!}
							<div class="form-group mb-2">
								{{ Form::select('export', $exports, !empty(request()->input('export')) ? request()->input('export') : null, ['placeholder' => '-- Export to --', 'class' => 'form-control input-block']) }}
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<button type="submit" class="btn btn-primary btn-default">Go</button>
							</div>
						{!! Form::close() !!}
						<table class="table table-bordered table-striped">
							<thead>
								<th>Name</th>
								
								<th>Stock</th>
							</thead>
							<tbody>
								@forelse ($products as $product)
									<tr>    
										<td>{{ $product->nama_barang }}</td>
										
										<td>{{ $product->stock }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="3">No records found</td>
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