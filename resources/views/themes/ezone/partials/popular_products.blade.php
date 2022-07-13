<!-- product area start -->
@if ($barangs)
	<div class="popular-product-area wrapper-padding-3 pt-115 pb-115">
		<div class="container-fluid">
			<div class="section-title-6 text-center mb-50">
				<h2>Popular Product</h2>
				{{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text</p> --}}
			</div>
			<div class="product-style">
				<div class="popular-product-active owl-carousel">
					@foreach ($barangs as $barang)
						@php
							$barang = $barang->parent ?: $barang;	
						@endphp
						<div class="product-wrapper">
							<div class="product-img">
								<a href="{{ url('products/'. $barang->id_barang) }}">
									@if ($barang->gambar)
										<img src="{{ asset('storage/barangs/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}"  style="width:400px; height: 400px;">
									@else
									<img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $barang->nama_barang }}">
									@endif
								</a>
								<div class="product-action">
									<a class="animate-left add-to-fav" title="Wishlist"  product-slug="{{ $barang->id_barang }}" href="">
										<i class="pe-7s-like"></i>
									</a>
									<a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $barang->id_barang }}" {{-- product-type="{{ $barang->jenis_barang_id }}" product-slug="{{ $barang->id_barang }}" --}}>
										<i class="pe-7s-cart"></i>
									</a>
									<a class="animate-right quick-view" title="Quick View" product-slug="{{ $barang->id_barang }}" href="">
										<i class="pe-7s-look"></i>
									</a>
								</div>
							</div>
							<div class="funiture-product-content text-center">
								<h4><a href="{{ url('products/'. $barang->id_barang) }}">{{ $barang->nama_barang }}</a></h4>
								<span>{{ number_format($barang->harga_jual) }}</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<!-- product area end -->
@endif