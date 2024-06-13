<div class="navbar-custom">
    <div class="topbar">
        <div class="topbar-menu d-flex align-items-center gap-lg-2 gap-1">

            <!-- Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="{{ route('dashboard') }}" class="logo-light">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="logo" class="logo-lg" height="22">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="small logo" class="logo-sm" height="22">
                </a>

                <!-- Brand Logo Dark -->
                <a href="{{ route('dashboard') }}" class="logo-dark">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="dark logo" class="logo-lg" height="22">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="small logo" class="logo-sm" height="22">
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-4">
            {{-- for notification if required --}}
            <li class="nav-link" id="theme-mode">
                <i class="bx bx-moon font-size-24"></i>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ url('assets/images/users/avatar-4.jpg') }}" alt="user-image" class="rounded-circle">
                    <span class="ms-1 d-none d-md-inline-block">
                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>Settings</span>
                    </a>
                    <!-- item-->
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </li>

        </ul>
    </div>
</div>
