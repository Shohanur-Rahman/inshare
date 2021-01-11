<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TREELLC INSHARE</title>
    <!-- base:css -->

    <link rel="stylesheet" href="{{asset('admin/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.2.617/styles/kendo.default-v2.min.css" />
    <!-- endinject -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/js/dataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/admin.custom.css')}}">

    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
    <!-- base:js -->
    <script src="{{asset('admin/js/vendor.bundle.base.js')}}"></script>

    <!-- endinject -->
    <script src="https://kendo.cdn.telerik.com/2020.2.617/js/kendo.all.min.js"></script>
    <script src="{{asset('admin/js/plugins/sweetalert.min.js')}}"></script>
    <script src="{{asset('admin/js/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/uploader/dropify/dropify.min.js')}}"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{asset('admin/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
<!-- <script src="{{asset('admin/js/template.js')}}"></script> -->
    <script src="{{asset('admin/js/alerts.js')}}"></script>
    <script src="{{asset('admin/js/parsley/parsley.min.js')}}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{asset('admin/js/dashboard.js')}}"></script>
    <script src="{{asset('admin/app-js/custom.js')}}"></script>
    <!-- End custom js for this page-->
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center">
            <a class="navbar-brand brand-logo ml-auto mr-auto" href="{{route('dashboard')}}"><img src="{{asset(\Illuminate\Support\Facades\Auth::user()->company_logo)}}" alt="logo" class="logo-img" /></a>
            <a class="navbar-brand brand-logo-mini ml-auto mr-auto" href="{{route('dashboard')}}"><img src="{{asset(\Illuminate\Support\Facades\Auth::user()->company_logo)}}" alt="logo" class="logo-img" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <span class="header-titile">Welcome to {{\Illuminate\Support\Facades\Auth::user()->company_name}}</span>

            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown"><a href=""><span class="user-name" style="display:none">{{ Auth::user()->name }}</span></a></li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">

                        <img src="{{asset('admin/img/face11.jpg')}}" alt="profile" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout"></i>
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                @if(Auth::user()->role_id == 1)
                    <li class="nav-item admin_menu">
                        <a class="nav-link" href="{{route('admin_panel')}}">
                            <i class="mdi mdi-clipboard-text-outline menu-icon"></i>
                            <span class="menu-title">Admin</span>
                        </a>
                    </li>
                @endif


                <li class="nav-item dashboard_menu">
                    <a class="nav-link" href="{{route('dashboard')}}">
                        <i class="mdi mdi-chart-donut menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item application_menu">
                    <a class="nav-link" href="{{route('applications.index')}}">
                        <i class="mdi mdi-cube-outline menu-icon"></i>
                        <span class="menu-title">Applications</span>
                    </a>
                </li>

                <li class="nav-item documents_menu">
                    <a class="nav-link" href="{{route('documents.index')}}">
                        <i class="mdi mdi-cube-outline menu-icon"></i>
                        <span class="menu-title">Documents</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>



</body>

</html>
