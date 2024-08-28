<x-app-layout>
    <x-slot name="page">Data Laporan</x-slot>
    <ul class="nav nav-tabs" role="tablist">
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Bendahara->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=Simpan Pinjam' }}"
                    class="nav-link {{ request()->get('tab') == 'Simpan Pinjam' || request()->get('tab') == null ? 'active' : '' }}"
                    role="tab" tabindex="-1">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-inline-block">Simpan Pinjam</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Kasir->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=Pertokoan' }}"
                    class="nav-link {{ request()->get('tab') == 'Pertokoan' ? 'active' : '' }}">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-inline-block">Pertokoan</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Jasa->value)
            <li class="nav-item" role="presentation">
                <a href="{{ url()->current() . '?tab=Jasa Angkutan' }}"
                    class="nav-link {{ request()->get('tab') == 'Jasa Angkutan' ? 'active' : '' }}">
                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-inline-block">Jasa Angkutan</span>
                </a>
            </li>
        @endif
    </ul>
    <div class="tab-content">
        @if (request()->get('tab') == 'Simpan Pinjam')
            @include('laporan.koperasi')
        @elseif (request()->get('tab') == 'Pertokoan')
            @include('laporan.toko')
        @else
            @include('laporan.jasa')
        @endif
    </div>
</x-app-layout>
