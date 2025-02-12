<x-app-layout>
    <x-slot name="page">Data Laporan</x-slot>
    <ul class="nav nav-tabs" role="tablist">
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Bendahara->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=simpan_pinjam' }}"
                    class="nav-link {{ request()->get('tab') == 'simpan_pinjam' ? 'active' : '' }}" role="tab"
                    tabindex="-1">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-inline-block">Simpan Pinjam</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Kasir->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=toko' }}"
                    class="nav-link {{ request()->get('tab') == 'toko' ? 'active' : '' }}">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-inline-block">Pertokoan</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Jasa->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=jasa' }}"
                    class="nav-link {{ request()->get('tab') == 'jasa' ? 'active' : '' }}">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-inline-block">Jasa Angkutan</span>
                </a>
            </li>
        @endif
    </ul>
    <div class="tab-content">
        @if (request()->get('tab') == 'simpan_pinjam' || request()->get('tab') == null)
            @include('laporan.koperasi')
        @elseif (request()->get('tab') == 'toko')
            @include('laporan.toko')
        @else
            @include('laporan.jasa')
        @endif
    </div>
</x-app-layout>
