<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>WIN STREAX</title>

    <!-- Favicon -->
    <link rel="icon" href="{{asset('assets/img/client/core-img/favicon.ico')}}">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/css/client/style.css')}}">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    {{-- Navbar Component --}}
    @include('layout.client.navbar')

    {{-- Content --}}
    @yield('content')

    {{-- Navbar Component --}}
    @include('layout.client.footer')

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="{{asset('assets/js/client/jquery/jquery-2.2.4.min.js')}}"></script>
    <!-- Popper js -->
    <script src="{{asset('assets/js/client/bootstrap/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/client/bootstrap/bootstrap.min.js') }}"></script>
    <!-- All Plugins js -->
    <script src="{{ asset('assets/js/client/plugins/plugins.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('assets/js/client/active.js') }}"></script>
</body>

</html>