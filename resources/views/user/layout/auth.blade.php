<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | ODA Member Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .auth-one-bg {
            background-image: url('https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        .auth-full-page-content {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }
        /* Overriding the default Velzon auth bg for users */
        .user-auth-wrapper {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper user-auth-wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-7 d-none d-lg-block">
                    <div class="auth-one-bg h-100 p-5 d-flex align-items-end">
                        <div class="bg-overlay bg-primary opacity-50"></div>
                        <div class="position-relative">
                            <h2 class="text-white display-5 fw-bold">Building Oko-Irese <br> Together.</h2>
                            <p class="text-white-50 fs-18">Your contributions fuel progress. Track your impact, view development initiatives, and stay connected with the ODA community.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100" style="max-width: 400px;">
                            <div class="mb-5 text-center">
                                <a href="/" class="d-block auth-logo">
                                    <span class="h3 fw-bold text-primary">ODA <span class="text-dark">eFund</span></span>
                                </a>
                                <p class="text-muted mt-2">Member Portal Access</p>
                            </div>

                            @yield('content')

                            <div class="mt-5 text-center">
                                <p class="mb-0 text-muted">
                                    &copy; <script>document.write(new Date().getFullYear())</script> ODA. <br>
                                    <small>Transparency. Progress. Community.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>