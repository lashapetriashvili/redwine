<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo 3 (200X200).png') }}" />
        <link rel="icon" type="image/png" href="{{ asset('assets/img/logo 3 (200X200).png') }}" />
        <title>Redwine - @yield('title')</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/bower_components/components-font-awesome/css/font-awesome.css') }}">
        <!-- style -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <!-- alert -->
        <link href="{{ asset('assets/css/alert.css') }}" rel="stylesheet" />
        <!-- sweetalert2 -->
        <link href="{{ asset('assets/bower_components/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <!-- jQuery UI -->
        <link rel="stylesheet" href="{{ asset('assets/bower_components/jquery-ui/themes/base/jquery-ui.css') }}">
        <!-- Nice-select -->
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    @stack('styles')
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar">
                <div class="logo">
                    <a href="/redwine" class="simple-text">
                        RedWine<small>{{ strtoupper(Auth::user()->name) }}</small>
                    </a>
                </div>
                <div class="sidebar-wrapper">
                    {!! Redwine::menu('redwine', [
                        'main-ul-class' => 'nav',
                        'active'        => 'active',
                    ]) !!}
                </div>
            </div>
            <div class="main-panel">
                <nav class="navbar navbar-transparent navbar-absolute">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand"> @yield('navbar-title') </a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">person</i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-primary">
                                        <li>
                                            <a href="/redwine/page/users">მომხმარებელი</a>
                                        </li>
                                        <li>
                                            <a href="/redwine/logout">გასვლა</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content vue">
                    <div class="container-fluid">
                        <div class="row">
                            @yield('content') 
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <nav class="pull-left">
                            {!! Redwine::menu('footer redwine') !!}
                        </nav>
                        <p class="copyright pull-right">
                            &copy; {{ date("Y") }}
                            <a href="https://www.redwine.webhouse.ge" target="_blank">Created By Web House Studio</a> v{{ redwine::setting('version') }}
                        </p>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Core JS Files -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- Material -->
        <script src="{{ asset('assets/js/material.min.js') }}"></script>
        <!-- Charts Plugin -->
        <script src="{{ asset('assets/js/chartist.min.js') }}"></script>
        <!-- Dynamic Elements plugin -->
        <script src="{{ asset('assets/js/arrive.min.js') }}"></script>
        <!-- PerfectScrollbar Library -->
        <script src="{{ asset('assets/js/perfect-scrollbar.jquery.min.js') }}"></script>
        <!-- Notifications Plugin -->
        <script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>
        <!-- Nice-select -->
        <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
        <!-- Dashboard javascript methods -->
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <!-- sweetalert2 -->
        <script src="{{ asset('assets/bower_components/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <!-- Alert js -->
        <script src="{{ asset('assets/js/alert.js') }}"></script>
        <!-- Vue -->
        <script src="{{ asset('assets/js/vue.js') }}"></script>
        <!-- Vue resource -->
        <script src="{{ asset('assets/bower_components/vue-resource/dist/vue-resource.js') }}"></script>
        <!-- Vee-validate -->
        <script src="{{ asset('assets/js/vee-validate.min.js') }}"></script>
        <!-- jQuery UI -->
        <script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.js') }}"></script>
        @stack('scripts')
    </body>
</html>
