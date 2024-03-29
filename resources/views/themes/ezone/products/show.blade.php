@extends('themes.ezone.layout')

@section('content')
	<div class="breadcrumb-area pt-205 pb-210" style="background-image: url({{ asset('themes/ezone/assets/img/bg/breadcrumb.jpg') }})">
		<div class="container">
			<div class="breadcrumb-content text-center">
				<h2>product details</h2>
				<ul>
					<li><a href="/">home</a></li>
					<li> product details </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-details ptb-100 pb-90">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-7 col-12">
					<div class="product-details-img-content">
						<div class="product-details-tab mr-70">
							<div class="product-details-large tab-content">
								<img src="{{ asset('storage/barangs/' . $product->gambar) }}" alt="{{ $product->nama_barang }}">
								
								{{-- @php
									$i = 1
								@endphp
								@forelse ($product->gambar as $image)
									<div class="tab-pane fade {{ ($i == 1) ? 'active show' : '' }}" id="pro-details{{ $i}}" role="tabpanel">
										<div class="easyzoom easyzoom--overlay">
											@if ($image->large && $image->extra_large)
												<a href="{{ asset('storage/'.$image->extra_large) }}">
													<img src="{{ asset('storage/'.$image->large) }}" alt="{{ $product->name }}">
												</a>
											@else
												<a href="{{ asset('themes/ezone/assets/img/product-details/bl1.jpg') }}">
													<img src="{{ asset('themes/ezone/assets/img/product-details/l1.jpg') }}" alt="{{ $product->name }}">
												</a>
											@endif
                                        </div>
									</div>
									@php
										$i++
									@endphp
								@empty
									No image found!
								@endforelse --}}
							</div>
							{{-- <div class="product-details-small nav mt-12" role=tablist>
								@php
									$i = 1
								@endphp
								@forelse ($product as $image)
									<a class="{{ ($i == 1) ? 'active' : '' }} mr-12" href="#pro-details{{ $i }}" data-toggle="tab" role="tab" aria-selected="true">
										@if ($image->small)
											<img src="{{ asset('storage/'.$image->small) }}" alt="{{ $product->name }}">
										@else
											<img src="{{ asset('themes/ezone/assets/img/product-details/s1.jpg') }}" alt="{{ $product->name }}">
										@endif
									</a>
									@php
										$i++
									@endphp
								@empty
									No image found!
								@endforelse
							</div> --}}
						</div>
					</div>
				</div>
				<div class="col-md-12 col-lg-5 col-12">
					<div class="product-details-content">
						<h3>{{ $product->nama_barang }}</h3>
						<div class="details-price">
							<span>Rp. {{ number_format($product->harga_jual) }}</span>
						</div>
						<p>{{ $product->keterangan }}</p>
						<p>Stok Tersisa : {{ $product->persediaanstok->stok }}</p>
						{!! Form::open(['url' => 'carts']) !!}
							{{ Form::hidden('barang_id', $product->id_barang) }}
							@if ($product->jenis->jenis == 'configurable')
								<div class="quick-view-select">
									<div class="select-option-part">
										<label>Size*</label>
										{{-- {!! Form::select('size', $sizes , null, ['class' => 'select', 'placeholder' => '- Please Select -', 'required' => true]) !!} --}}
									</div>
									<div class="select-option-part">
										<label>Color*</label>
										{{-- {!! Form::select('color', $colors , null, ['class' => 'select', 'placeholder' => '- Please Select -', 'required' => true]) !!} --}}
									</div>
								</div>
							@endif

							<div class="quickview-plus-minus">
								<div class="cart-plus-minus">
									{!! Form::number('jumlah', 1, ['class' => 'cart-plus-minus-box', 'placeholder' => 'jumlah', 'min' => 1]) !!}
								</div>
								<div class="quickview-btn-cart">
									<button type="submit" class="submit contact-btn btn-hover">add to cart</button>
								</div>
								<div class="quickview-btn-wishlist">
									<a class="btn-hover" href="#"><i class="pe-7s-like"></i></a>
								</div>
							</div>
						{!! Form::close() !!}
						<div class="product-details-cati-tag mt-35">
							<ul>
								<li class="categories-title">Categories :</li>
								{{-- @foreach ($product->jenis as $category) --}}
									<li><a href="{{ url('products/category/'. $product->jenis->id_jenis_barang ) }}">{{ $product->jenis->jenis }}</a></li>
								{{-- @endforeach --}}
							</ul>
						</div>
						
						<div class="product-share">
							<ul>
								<li class="categories-title">Share :</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-facebook"></i>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-twitter"></i>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-instagram"></i>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icofont icofont-social-whatsapp"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="product-description-review-area pb-90">
		<div class="container">
			<div class="product-description-review text-center">
				<div class="description-review-title nav" role=tablist>
					<a class="active" href="#pro-dec" data-toggle="tab" role="tab" aria-selected="true">
						Description
					</a>
					<a href="#pro-review" data-toggle="tab" role="tab" aria-selected="false">
						Spesifikasi
					</a>
				</div>
				<div class="description-review-text tab-content">
					<div class="tab-pane active show fade" id="pro-dec" role="tabpanel">
						<p>{{ $product->keterangan }} </p>
					</div>
					<div class="tab-pane fade" id="pro-review" role="tabpanel">
						<table class="table">
							<tbody>
								<tr>
									<td>
										<h5>Berat :</h5>
									</td>
									<td>
                                        <h5>{{ $product->berat_barang }} gr</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Harga :</h5>
									</td>
									<td>
										<h5>Rp {{ number_format($product->harga_jual) }}</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Kategori :</h5>
									</td>
									<td>
										<h5>{{ $product->jenis->jenis }}</h5>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection