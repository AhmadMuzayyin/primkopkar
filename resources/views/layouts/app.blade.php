<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">

<head>
    <meta charset="utf-8" />
    <title>Admin | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi PRIMKOPKAR PERUM PERHUTANI Kabupaten Pamekasan" name="description" />
    <meta content="Ust Dev" name="author" />
    <!-- App Styling -->
    <!-- third party css -->
    <link href="{{ url('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}">
    <link href="{{ url('assets/libs/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ url('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Begin page -->
    <div class="layout-wrapper">
        <!-- ========== Left Sidebar ========== -->
        <div class="main-menu">
            <!-- Brand Logo -->
            <div class="logo-box mt-2">
                <!-- Brand Logo Light -->
                <a href="{{ route('dashboard') }}" class="logo-light">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="logo" class="logo-lg" width="50">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="small logo" class="logo-sm" width="50">
                </a>
                <!-- Brand Logo Dark -->
                <a href="{{ route('dashboard') }}" class="logo-dark">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="dark logo" class="logo-lg" width="50">
                    <img src="https://primkopkar.wordpress.com/wp-content/uploads/2018/07/logo-koperasi-kartika-1.png"
                        alt="small logo" class="logo-sm" width="50">
                </a>
            </div>
            <!--- Menu -->
            @include('layouts.navigation')
        </div>
        <!-- Start Page Content here -->
        <div class="page-content">
            <!-- ========== Topbar Start ========== -->
            @include('layouts.topbar')
            <!-- ========== Topbar End ========== -->
            <div class="px-3">
                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="py-3 py-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="page-title mb-0">{{ $page ?? 'Dashboard' }}</h4>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-none d-lg-block">
                                    <ol class="breadcrumb m-0 float-end">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">PRIMKOPKAR</a></li>
                                        <li class="breadcrumb-item active">{{ $page ?? 'Dashboard' }}</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    {{ $slot }}
                </div> <!-- container -->
            </div> <!-- content -->
            <!-- Footer Start -->
            @include('layouts.footer')
            <!-- end Footer -->
        </div>
        <!-- End Page content -->
    </div>
    <!-- END wrapper -->
    <!-- App js -->
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>
    <script src="{{ url('assets/js/app.js') }}"></script>
    <script src="{{ url('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ url('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ url('assets/libs/morris.js/morris.min.js') }}"></script>
    <script src="{{ url('assets/libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ url('assets/js/pages/dashboard.js') }}"></script>
    <!-- third party js -->
    <script src="{{ url('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ url('assets/js/pages/datatables.js') }}"></script>
    <script src="{{ url('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- third party js ends -->
    @if (flash()->message)
        <script>
            Swal.fire({
                icon: '{{ flash()->class }}',
                title: '{{ flash()->message }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
    @stack('js')
</body>

</html>
