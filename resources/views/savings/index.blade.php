<x-app-layout>
    <x-slot name="page">Simpanan</x-slot>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ url()->current() . '?tab=setoran' }}"
                                class="nav-link {{ request()->get('tab') == 'setoran' || request()->get('tab') == null ? 'active' : '' }}"
                                role="tab" tabindex="-1">
                                <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                <span class="d-none d-sm-inline-block">Setoran</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ url()->current() . '?tab=penarikan' }}"
                                class="nav-link {{ request()->get('tab') == 'penarikan' ? 'active' : '' }}">
                                <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                <span class="d-none d-sm-inline-block">Penarikan</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @if (request()->get('tab') == 'setoran')
                            @include('savings.setoran')
                        @elseif (request()->get('tab') == 'penarikan')
                            @include('savings.penarikan')
                        @else
                            @include('savings.setoran')
                        @endif
                    </div>
                </div>

            </div> <!-- end card -->
        </div>
    </div>
</x-app-layout>
