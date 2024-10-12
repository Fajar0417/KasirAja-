<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
        </div>
        <div class="pull-left info">
                <p>
                {{ auth()->user()->name }}
                </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li>
          <a href="{{ route('dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        @if (auth()->check() && auth()->user()->level == 1)
        <li class="header">Master Data</li>
        <li>
          <a href="{{ route('kategori.index') }}">
          <i class="fa fa-tasks"></i> <span>Kategori</span>
          </a>
        </li>
        <li>
          <a href=" {{ route('produk.index') }}">
          <i class="fa fa-cubes"></i> <span>Produk</span>
          </a>
        </li>
        <li>
          <a href="{{ route('supplier.index') }}">
          <i class="fa fa-truck"></i> <span>Supplier</span>
          </a>
        </li>
        <li>
          <a href=" {{ route('member.index') }}">
          <i class="fa fa-users"></i> <span>Member</span>
          </a>
        </li>

        <li class="header">Transaksi</li>
        <li>
          <a href="{{ route('pembelian.index') }}">
          <i class="fa fa-credit-card-alt"></i> <span> Transaksi Pembelian</span>
          </a>
          </li>
          <li>
            <a href="{{ route('transaksi.baru') }}">
            <i class="fa fa-money"></i> <span>Transaksi Penjualan</span>
            </a>
          </li>
          <li>
            <a href="{{ route('penjualan.index') }}">
            <i class="fa fa-table"></i> <span>Daftar Penjualan</span>
            </a>
          </li>
          <!-- <a href="{{ route('transaksi.index') }}">
          <i class="fa fa-check-square-o"></i> <span>Transaksi Aktif</span>
          </a> -->
          <li>
            <a href="{{ route('pengeluaran.index') }}">
            <i class="fa fa-check-square-o"></i> <span>Pengeluaran</span>
            </a>
          </li>
        </li>

        <li class="header">Report</li>
        <li>
          <a href="{{ route('laporan.index') }}">
          <i class="fa fa-file-text"></i> <span>Laporan Pendapatan</span>
          </a>
        </li>
        <li class="header">SYSTEM</li>
        <li>
          <a href="{{ route('user.index')}}">
          <i class="fa fa-user-circle"></i> <span>User</span>
          </a>
        </li>
        <!-- <li>
          <a href="#">
          <i class="fa fa-cart-arrow-down"></i> <span>Laporan Stok Produk</span>
          </a>
        </li> -->
        <li>
          <a href="{{ route('setting.index')}}">
          <i class="fa fa-cogs"></i> <span>Pengaturan</span>
          </a>
        </li>
        @else
        <li>
          <a href="{{ route('transaksi.baru') }}">
          <i class="fa fa-money"></i> <span>Transaksi</span>
          </a>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>