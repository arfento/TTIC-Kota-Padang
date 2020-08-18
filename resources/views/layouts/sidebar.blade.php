<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{url('/images/user.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">{{ Auth::user()->name }} <span class="caret"></span></a>
            </div>
          </div>
        

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('/home') }}"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
            <li class="active"><a href="{{ route('rak.index') }}"><i class="fa fa-link"></i> <span>Rak</span></a></li>
            <li class="active"><a href="{{ route('satuanpenjualan.index') }}"><i class="fa fa-link"></i> <span>Satuan Penjualan</span></a></li>
            <li class="active"><a href="{{ route('satuanpembelian.index') }}"><i class="fa fa-link"></i> <span>Satuan Pembelian</span></a></li>
            <li class="active"><a href="{{ route('supplier.index') }}"><i class="fa fa-link"></i> <span>Supplier</span></a></li>
            <li class="active"><a href="{{ route('jenisbarang.index') }}"><i class="fa fa-link"></i> <span>Jenis Barang</span></a></li>
            <li class="active"><a href="{{ route('barang.index') }}"><i class="fa fa-link"></i> <span>Barang</span></a></li>
            <li class="active"><a href="{{ route('pembelian.index') }}"><i class="fa fa-link"></i> <span>Pembelian</span></a></li>
            <li class="active"><a href="{{ route('detailpembelian.index') }}"><i class="fa fa-link"></i> <span>Detail Pembelian</span></a></li>
            <li class="active"><a href="{{ route('penjualan.index') }}"><i class="fa fa-link"></i> <span>Penjualan</span></a></li>
            <li class="active"><a href="{{ route('detailpenjualan.index') }}"><i class="fa fa-link"></i> <span>Detail Penjualan</span></a></li>
            <li class="active"><a href="{{ route('persediaan.index') }}"><i class="fa fa-link"></i> <span>Persediaan</span></a></li>
           





        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
