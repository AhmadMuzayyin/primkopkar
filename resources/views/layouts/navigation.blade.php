<div data-simplebar>
    <ul class="app-menu mt-3">
        {{-- dashboard --}}
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                <span class="menu-text"> Dashboards </span>
            </a>
        </li>
        @if (Auth::user()->role == App\Role::Admin->value)
            {{-- kategori --}}
            <li class="menu-item">
                <a href="#kategori" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class="bx bx-cookie"></i></span>
                    <span class="menu-text"> Menejemen Kategori </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="kategori">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('saving_categories.index') }}" class="menu-link">
                                <span class="menu-text">Simpanan</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('loan_categories.index') }}" class="menu-link">
                                <span class="menu-text">Pinjaman</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- simpan pinjam --}}
            <li class="menu-item">
                <a href="#menuComponentsui" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class="bx bx-cookie"></i></span>
                    <span class="menu-text"> Transaksi </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuComponentsui">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('savings.index') }}" class="menu-link">
                                <span class="menu-text">Simpanan</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('loans.index') }}" class="menu-link">
                                <span class="menu-text">Pinjaman</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        {{-- pos --}}
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Kasir->value)
            <li class="menu-item">
                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                    <span class="menu-text"> POS </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menuExpages">
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="{{ route('category.index') }}" class="menu-link">
                                <span class="menu-text">Kategori</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('products.index') }}" class="menu-link">
                                <span class="menu-text">Data Barang</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('stocks.index') }}" class="menu-link">
                                <span class="menu-text">Stok Barang</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('product_transactions.index') }}" class="menu-link">
                                <span class="menu-text">Transaksi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        {{-- jasa --}}
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Jasa->value)
            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                    <span class="menu-text"> Transaksi Jasa </span>
                </a>
            </li>
        @endif
        {{-- laporan --}}
        @if (Auth::user()->role == App\Role::Admin->value)
            <li class="menu-item">
                <a href="{{ route('members.index') }}" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class='bx bxs-user-badge'></i></span>
                    <span class="menu-text"> Member </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('users.index') }}" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class="bx bx-user"></i></span>
                    <span class="menu-text"> Pengguna </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                    <span class="menu-icon"><i class='bx bx-line-chart'></i></span>
                    <span class="menu-text"> Laporan </span>
                </a>
            </li>
        @endif
    </ul>
</div>
