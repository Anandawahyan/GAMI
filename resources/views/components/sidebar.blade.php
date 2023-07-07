<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    @if(Auth::user()->role == 'executive')
                    <li class='{{ Request::is('executive/dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('executive/dashboard') }}">General Dashboard</a>
                    </li>
                    @else
                    <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('dashboard.index') }}">Admin Dashboard</a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'barang' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-box-open"></i><span>Barang</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('admin/barang') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('admin/barang') }}">Semua Barang</a>
                    </li>
                    @if(Auth::user()->role == 'admin')
                    <li class="{{ Request::is('admin/barang/create') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/barang/create') }}">Tambah Barang</a>
                    </li>
                    <li class="{{ Request::is('admin/sampah') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('admin/sampah') }}">Sampah</a>
                    </li>
                    @endif
                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'order' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-file-invoice-dollar"></i><span>Order</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('admin/order') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('admin/order') }}">Semua Order</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="/admin/activity">Riwayat</a>
            </li>
            @if(Auth::user()->role == 'executive')
            <li class="nav-item">
                <a href="/admin/karyawan">Karyawan</a>
            </li>
            @endif
            {{-- {{-- <li class="menu-header">Starter</li>
            <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-default-layout') }}">Default Layout</a>
                    </li>
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('transparent-sidebar') }}">Transparent Sidebar</a>
                    </li>
                    <li class="{{ Request::is('layout-top-navigation') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-top-navigation') }}">Top Navigation</a>
                    </li>
                </ul>
            </li> --}}
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="/idoc"
                class="btn btn-primary btn-lg btn-block w-100 text-start">
                <i class="fas fa-rocket"></i>
                <span class="d-inline-block">Documentation</span>
            </a>
        </div>
    </aside>
</div>
