<!-- header start -->
<header>
	<div class="header-top-furniture wrapper-padding-2 res-header-sm">
		<div class="container-fluid">
			<div class="header-bottom-wrapper">
				<div class="logo-2 furniture-logo ptb-30">
					<a href="/">
						<img src="{{ asset('themes/ezone/assets/img/logo/logo1.png') }}" alt="" width="80" height="80">
					</a>
				</div>
				<div class="menu-style-2 furniture-menu menu-hover">
					<nav>
						<ul>
							<li><a href="/">home</a>

							</li>
							<li><a href="#">pages</a>
								<ul class="single-dropdown">

									<li><a href="{{ url('login') }}">login</a></li>
									<li><a href="{{ url('register') }}">register</a></li>
									<li><a href="{{ url('carts') }}">cart page</a></li>
									<li><a href="{{ url('orders') }}">Pesanan</a></li>
									<li><a href="{{ url('favorites') }}">wishlist</a></li>
								</ul>
							</li>
							<li><a href="{{ url('products') }}">Produks</a>
							</li>
							@guest
							<li><a href="{{ url('login') }}">Login</a></li>
							<li><a href="{{ url('register') }}">Register</a></li>
							@else
							<li><a href="{{ url('profile') }}">Profile</a></li>
							<li>
								<a class='text-dark' href="{{ route('logout') }}" onclick="event.preventDefault();
													document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>
							</li>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
							@endguest

						</ul>
					</nav>
				</div>
				@include('themes.ezone.partials.mini_cart')
			</div>
			
		</div>
	</div>
	<div class="header-bottom-furniture wrapper-padding-2 border-top-3">
		<div class="container-fluid">
			<div class="furniture-bottom-wrapper">
				<div class="furniture-login">
					<ul>
						@guest
						<li>Get Access: <a href="{{ url('login') }}">Login</a></li>
						<li><a href="{{ url('register') }}">Register</a></li>
						@else
						<li>Hello: <a href="{{ url('profile') }}">{{ Auth::user()->first_name }}</a></li>
						<a href="{{ route('logout') }}" onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						@endguest
					</ul>
				</div>
				<div class="furniture-search">
					<form action="{{ url('products') }}" method="GET">
						<input placeholder="I am Searching for . . ." type="text" name="q"
							value="{{ isset($q) ? $q : null }}">
						<button>
							<i class="ti-search"></i>
						</button>
					</form>
				</div>
				<div class="furniture-wishlist">
					<ul>
						<li><a href="{{ url('favorites') }}"><i class="ti-heart"></i> Favorites</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- header end -->