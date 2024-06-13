<div data-simplebar>
    <ul class="app-menu mt-3">
        {{-- dashboard --}}
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                <span class="menu-text"> Dashboards </span>
            </a>
        </li>
        {{-- kategori --}}
        <li class="menu-item">
            <a href="#menuComponentsui" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-cookie"></i></span>
                <span class="menu-text"> Menejemen Kategori </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuComponentsui">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Simpanan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
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
                        <a href="#" class="menu-link">
                            <span class="menu-text">Simpanan</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Pinjaman</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- pos --}}
        <li class="menu-item">
            <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-file"></i></span>
                <span class="menu-text"> POS </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuExpages">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Kategori</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Data Barang</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Stok Barang</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <span class="menu-text">Transaksi</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- jasa --}}
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                <span class="menu-text"> Transaksi Jasa </span>
            </a>
        </li>
        {{-- laporan --}}
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                <span class="menu-text"> Laporan </span>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link waves-effect waves-light">
                <span class="menu-icon"><i class="bx bx-home-smile"></i></span>
                <span class="menu-text"> Anggota </span>
            </a>
        </li>
    </ul>
</div>
