<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

@php
    $admin = Auth::guard('admin')->user();
@endphp

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | ODA eFund Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="ODA Community eFunding Management System" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .navbar-menu { border-right: 1px solid rgba(255,255,255,0.05); }
        .logo-lg h2 { color: #fff; margin-bottom: 0; padding: 20px 0; }
    </style>
</head>

<body>
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="{{ url('/admin/dashboard') }}" class="logo logo-dark">
                                <span class="logo-lg">
                                    <h4 class="mt-3 fw-bold">ODA <span class="text-primary">eFund</span></h4>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon"><span></span><span></span><span></span></span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        {{-- <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $notifications->count() }}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">System Alerts</h6>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    @foreach($notifications as $n)
                                    <div class="text-reset notification-item d-block dropdown-item">
                                        <div class="d-flex">
                                            <div class="flex-1">
                                                <h6 class="mt-0 mb-1 fs-13 fw-semibold">New Contribution</h6>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">{{ $n->message }}</p>
                                                </div>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> {{ $n->created_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> --}}

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/user-dummy-img.jpg') }}" alt="Admin">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ $admin->name }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Super Admin</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <h6 class="dropdown-header">Management</h6>
                                <a class="dropdown-item" href="{{ url('/admin/profile') }}"><i class="ri-account-circle-line text-muted fs-16 align-middle me-1"></i> My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ri-logout-box-line text-muted fs-16 align-middle me-1"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="{{ url('/admin/dashboard') }}" class="logo logo-light">
                    <span class="logo-lg">
                        <h3 class="text-white fw-bold mt-4">ODA <span class="text-info">eFund</span></h3>
                    </span>
                    <span class="logo-sm">
                        <span class="text-white fw-bold">ODA</span>
                    </span>
                </a>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span>Main</span></li>
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/dashboard') }}">
                                <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title"><span>Community Management</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link collapsed" href="#sidebarMembers" data-bs-toggle="collapse" role="button">
                                <i class="ri-group-line"></i> <span>Manage Members</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarMembers">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="{{ url('/admin/members/resident') }}" class="nav-link">Resident Members</a></li>
                                    <li class="nav-item"><a href="{{ url('/admin/members/diaspora') }}" class="nav-link">Diaspora Members</a></li>
                                    <li class="nav-item"><a href="{{ url('/admin/members/all') }}" class="nav-link">All Records</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-title"><span>Development Control</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/projects') }}">
                                <i class="ri-building-line"></i> <span>Community Projects</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/campaigns') }}">
                                <i class="ri-rocket-line"></i> <span>Fundraising Campaigns</span>
                            </a>
                        </li>

                        <li class="menu-title"><span>Financials</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/levies') }}">
                                <i class="ri-hand-coin-line"></i> <span>Levy Settings</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/contributions') }}">
                                <i class="ri-money-dollar-circle-line"></i> <span>Contributions</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/admin/expenditure') }}">
                                <i class="ri-shopping-bag-3-line"></i> <span>Expenditures</span>
                            </a>
                        </li>

                        <li class="menu-title"><span>Reports & Audit</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/reports/financial') }}">
                                <i class="ri-file-chart-line"></i> <span>Financial Statements</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('admin/audit-logs') }}">
                                <i class="ri-shield-user-line"></i> <span>Audit Logs</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">@yield('page-title')</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">@yield('page-title')</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © ODA eFund.
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            Developed for Oko-Irese Community Development
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>