<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page }} {{ config('app.name') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('logo-pizza.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/loader.css') }}"> --}}
    <script src="{{ asset('js/feather-icons.js') }}"></script>
    @include('includes.customCss')
    @yield('css')
</head>
<body>
    <div id="spinner" class="bg-white">
        <center>
            <div class="spinner-border text-warning mt-5" role="status"></div>
        </center>
    </div>
    @yield('content')

    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script>
        $(document).ready( function () {
            $('#spinner').fadeOut();
            feather.replace()
        });
        function alert_confirm(url,title =''){
            Swal.fire({
                title: title+'?',
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
    @yield('script')
</body>
</html>
