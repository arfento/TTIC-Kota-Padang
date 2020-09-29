@extends('layouts.ecommerce')

@section('title')
    <title>Jual {{ $barang->nama_barang }}</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
	<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center">
                    <h2>{{ $barang->nama_barang }}</h2>
					<div class="page_link">
                        <a href="{{ url('/front') }}">Home</a>
                        <a href="#">{{ $barang->nama_barang }}</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Home Banner Area =================-->

	<div class="barang_image_area">
		<div class="container">
			<div class="row s_barang_inner">
				<div class="col-lg-6">
					<div class="s_barang_img">
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img class="d-block w-100" src="{{ asset('storage/barangs/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_barang_text">
						<h3>{{ $barang->nama_barang }}</h3>
                        <h2>Rp {{ number_format($barang->harga_jual) }}</h2>
						<ul class="list">
							<li>
								<a class="active" href="#">
                                    <span>Kategori</span> : {{ $barang->jenis->jenis }}</a>
							</li>
						</ul>
						{{-- <p>
							@if (auth()->guard('customer')->check())
							<label>Afiliasi Link</label>
							<input type="text" 
								value="{{ url('/barang/ref/' . auth()->guard('customer')->user()->id . '/' . $barang->id) }}" 
								readonly class="form-control">
							@endif
						</p> --}}
						<form action="{{ route('front.cart') }}" method="POST">
							@csrf
							<div class="barang_count">
								<label for="jumlah">Quantity:</label>
								<input type="text" name="jumlah" id="sst" maxlength="12" value="1" title="Jumlah:" class="input-text jumlah">
								<input type="hidden" name="barang_id" value="{{ $barang->id_barang }}" class="form-control">
								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
								class="increase items-count" type="button">
									<i class="lnr lnr-chevron-up"></i>
								</button>
								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
								class="reduced items-count" type="button">
									<i class="lnr lnr-chevron-down"></i>
								</button>
							</div>
							<div class="card_area">
								<button class="main_btn">Add to Cart</button>
							</div>

							@if (session('success'))
							<div class="alert alert-success mt-2">{{ session('success') }}</div>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single barang Area =================-->

	<!--================barang Description Area =================-->
	<section class="barang_keterangan_area">
		<div class="container">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">keterangan</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="color: black">
					{!! $barang->keterangan !!}
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>
										<h5>Satuan Penjualan</h5>
									</td>
									<td>
                                        <h5>{{ $barang->satuanPenjualan->satuan }} gr</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Harga</h5>
									</td>
									<td>
										<h5>Rp {{ number_format($barang->harga_jual) }}</h5>
									</td>
								</tr>
								<tr>
									<td>
										<h5>Kategori</h5>
									</td>
									<td>
										<h5>{{ $barang->jenis->jenis }}</h5>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End barang Description Area =================-->
@endsection