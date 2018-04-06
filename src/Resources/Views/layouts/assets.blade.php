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
        <link href="{{ asset('assets/css/alert.css') }}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    @stack('styles')
    </head>
    <body>
        
        @yield('content')     

        <!-- Core JS Files -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!-- <aterial -->
        <script src="{{ asset('assets/js/material.min.js') }}" type="text/javascript"></script>
        <!-- Charts Plugin -->
        <script src="{{ asset('assets/js/chartist.min.js') }}"></script>
        <!-- Dynamic Elements plugin -->
        <script src="{{ asset('assets/js/arrive.min.js') }}"></script>
        <!-- PerfectScrollbar Library -->
        <script src="{{ asset('assets/js/perfect-scrollbar.jquery.min.js') }}"></script>
        <!-- Notifications Plugin -->
        <script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>
        <!-- Dashboard javascript methods -->
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <!-- Alert js -->
        <script src="{{ asset('assets/js/alert.js') }}"></script>
        <!-- Vue -->
        <script src="{{ asset('assets/js/vue.js') }}"></script>
        <!-- Vue resource -->
        <script src="{{ asset('assets/bower_components/vue-resource/dist/vue-resource.js') }}"></script>
        @stack('scripts')
    </body>
</html>
