<div class="col-md-6 col-xl-3">
	<div class="product-wrapper mb-30">
		<div class="product-img">
			<a href="{{ url('products/'. $product->id_barang) }}">
				@if ($product->gambar)
				<img class="img-fluid" src="{{ asset('storage/barangs/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" style="width:400px; height: 400px;">
				@else
				<img class="img-fluid" src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/1.jpg') }}" alt="{{ $product->nama_barang }}" style="width:100px">
				@endif
			</a>
			<span>hot</span>
			<div class="product-action">
				<a class="animate-left add-to-fav" title="Favorite"  product-slug="{{ $product->id_barang }}" href="">
					<i class="pe-7s-like"></i>
				</a>
				<a class="animate-top add-to-card" title="Add To Cart" href="" product-id="{{ $product->id_barang }}" {{-- product-type="{{ $product->jenis->jenis }}" product-slug="{{ $product->slug }}" --}}>
					<i class="pe-7s-cart"></i>
				</a>
				<a class="animate-right quick-view" title="Quick View" product-slug="{{ $product->id_barang }}" href="">
					<i class="pe-7s-look"></i>
				</a>
			</div>
		</div>
		<div class="product-content">
			<h4><a href="{{ url('products/'. $product->id_barang) }}">{{ $product->nama_barang }}</a></h4>
			<span>{{ number_format($product->harga_jual) }}</span>
		</div>
	</div>
</div>