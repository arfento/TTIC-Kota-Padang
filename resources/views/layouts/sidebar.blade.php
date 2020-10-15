<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
        style="opacity: .8">
      <span class="brand-text font-weight-light">TTIC Kota Padang</span>
    </a>
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('/images/user.png')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->first_name  }} {{ Auth::user()->last_name  }} <span class="caret"></span></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview menu-open">
          <a href="{{ url('/home') }}" class="nav-link active">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Dashboard
              <i class="right"></i>
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Barang
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item has-treeview">
            <li class="nav-item">
              <a href="{{ route('barang.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Barang</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('jenisbarang.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Jenis Barang</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('satuanpembelian.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Satuan Pembelian</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('satuanpenjualan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Satuan Penjualan</span></a>
            </li>
            <li class="nav-item">
              <a href="{{ route('supplier.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Supplier</span></a>
            </li>


          </ul>
        </li>
        <li class="nav-item has-treeview menu-open">
          <a href="{{ route('persediaanperrak') }}" class="nav-link active">
            <i class="nav-icon fas fa-box-open"></i>
            <p>
              Persediaan
              <i class=""></i>
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>
              Transaksi
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">

            <li class="nav-item"><a href="{{ route('pembelian.index') }}" class="nav-link"><i
                  class="far fa-circle nav-icon"></i>
                <span>Pembelian</span></a></li>

            <li class="nav-item"><a href="{{ route('detailpembelian.index') }}" class="nav-link"><i
                  class="far fa-circle nav-icon"></i> <span>Detail
                  Pembelian</span></a></li>

            <li class="nav-item"><a href="{{ route('penjualan.index') }}" class="nav-link"><i
                  class="far fa-circle nav-icon"></i>
                <span>Penjualan</span></a></li>

            <li class="nav-item"><a href="{{ route('detailpenjualan.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Detail Penjualan</span></a></li>

            {{-- <li class="{{ ($currentAdminSubMenu == 'trashed-order') ? 'active' : ''}}"> --}}
            <li class="nav-item">
              <a class="nav-link" href="{{ route('penjualan.trashed')}}">
                <i class="far fa-circle nav-icon"></i>
                <span class="nav-text">Trashed</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('shipments.index')}}">
                <i class="far fa-circle nav-icon"></i>
                <span class="nav-text">Shipments</span>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link active" aria-controls="report" data-toggle="collapse" data-target="#report"
            aria-expanded="false">
            <i class="nav-icon fas fa-file"></i>
            <span>
              Reports
            </span>
            <i class="fas fa-angle-left right"></i>
          </a>

         
          <ul class="nav nav-treeview" style="display: none;">

            <li class="nav-item"><a href="{{ url('reports/revenue')}}" class="nav-link"><i
                  class="far fa-circle nav-icon"></i>
                <span>Laporan Transaksi Penjualan</span></a></li>

            <li class="nav-item"><a href="{{ url('reports/product')}}" class="nav-link"><i
                  class="far fa-circle nav-icon"></i>
                <span>Laporan Barangs</span></a></li>

            <li class="nav-item"><a href="{{ url('reports/product')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <span>Laporan Pembayaran</span></a></li>

            {{-- <li class="{{ ($currentAdminSubMenu == 'trashed-order') ? 'active' : ''}}"> --}}
            <li class="nav-item">
              <a class="nav-link" href="{{ url('reports/inventory')}}">
                <i class="far fa-circle nav-icon"></i>
                <span class="nav-text">Laporan Persediaan </span>
              </a>
            </li>

          </ul>
          
          {{-- <ul class="collapse {{ ($currentAdminMenu == 'report') ? 'show' : ''}}" id="report"
          data-parent="#sidebar-menu">
          <div class="sub-menu">
        <li class="{{ ($currentAdminSubMenu == 'report-revenue') ? 'active' : ''}}">
          <a class="sidenav-item-link" href="{{ url('admin/reports/revenue')}}">
            <span class="nav-text">Revenue</span>
          </a>
        </li>
        <li class="{{ ($currentAdminSubMenu == 'report-product') ? 'active' : ''}}">
          <a class="sidenav-item-link" href="{{ url('admin/reports/product')}}">
            <span class="nav-text">Products</span>
          </a>
        </li>
        <li class="{{ ($currentAdminSubMenu == 'report-inventory') ? 'active' : ''}}">
          <a class="sidenav-item-link" href="{{ url('admin/reports/inventory')}}">
            <span class="nav-text">Inventories</span>
          </a>
        </li>
        <li class="{{ ($currentAdminSubMenu == 'report-payment') ? 'active' : ''}}">
          <a class="sidenav-item-link" href="{{ url('admin/reports/payment')}}">
            <span class="nav-text">Payments</span>
          </a>
        </li>
        </div>
      </ul> --}}
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link active">
          <i class="nav-icon fas fa-cogs"></i>
          <p>
            Pengaturan
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview" style="display: none;">

          <li class="nav-item"><a href="{{ route('pembelian.index') }}" class="nav-link"><i
                class="far fa-circle nav-icon"></i>
              <span>Users</span></a></li>

          <li class="nav-item"><a href="{{ route('detailpembelian.index') }}" class="nav-link"><i
                class="far fa-circle nav-icon"></i> <span>Hak Akses Users</span></a></li>
      
        </ul>
      </li>
    </nav>

    <!-- Sidebar Menu -->

    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>