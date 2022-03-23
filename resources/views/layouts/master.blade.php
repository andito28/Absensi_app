<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Absensi PT Liny Jaya Informatika</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('template-admin') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('template-admin') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('template-admin') }}/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('template-admin') }}/assets/vendors/jquery-bar-rating/css-stars.css" />
    <link rel="stylesheet"
        href="{{ asset('template-admin') }}/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('template-admin') }}/assets/css/demo_1/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('template-admin') }}/assets/images/favicon.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('link')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('layouts.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div id="settings-trigger"><i class="mdi mdi-settings"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options selected" id="sidebar-default-theme">
                    <div class="img-ss rounded-circle bg-light border mr-3"></div>Default
                </div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme">
                    <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                </div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles default primary"></div>
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles light"></div>
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_navbar.html -->
            @include('layouts.navbar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    <!-- table row starts here -->
                    @yield('content')
                    <!-- doughnut chart row starts -->
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('template-admin') }}/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('template-admin') }}/assets/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/flot/jquery.flot.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/flot/jquery.flot.categories.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="{{ asset('template-admin') }}/assets/vendors/flot/jquery.flot.stack.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('template-admin') }}/assets/js/off-canvas.js"></script>
    <script src="{{ asset('template-admin') }}/assets/js/hoverable-collapse.js"></script>
    <script src="{{ asset('template-admin') }}/assets/js/misc.js"></script>
    <script src="{{ asset('template-admin') }}/assets/js/settings.js"></script>
    <script src="{{ asset('template-admin') }}/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('template-admin') }}/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    @yield('script')
</body>

</html>
