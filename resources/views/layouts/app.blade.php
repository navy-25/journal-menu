<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page }} - {{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('app-assets/images/meta.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <script src="{{ asset('js/feather-icons.js') }}"></script>
    @include('includes.customCss')
    @yield('css')

    <style>
        @media screen and (min-width: 768px) {
            body {
                max-width: 450px;
                margin: 0 auto
            }
            html {
                background: rgb(37, 37, 37);
            }
        }
    </style>
</head>
<body>
    <div id="spinner">
        <center>
            {{-- <div class="spinner-border text-warning mt-5" role="status"></div> --}}
            <img width="100px" src="{{ asset('app-assets/images/pizza.gif') }}" alt="">
        </center>
    </div>
    @yield('content')

    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    @include('includes.globalJs')
    @yield('script')
</body>
</html>
