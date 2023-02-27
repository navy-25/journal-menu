<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page }} {{ config('app.name') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('app-assets/images/logo-pizza.png') }}">

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
    </head>
    <body>
        <div id="spinner" class="bg-white">
            <center>
                {{-- <div class="loadingio-spinner-bean-eater-ybl8jhu3zcq">
                    <div class="ldio-63eo66kwxha">
                        <div><div></div><div></div><div></div></div><div><div></div><div></div><div></div></div>
                    </div>
                </div> --}}
                <center>
                    <div class="spinner-border text-warning mt-5" role="status"></div>
                </center>
            </center>
        </div>
        @if (date('H:i') > '22:00' && date('H:i') < '23:59')
            <div style="position: fixed;bottom:100px;left:20px;z-index:999">
                <div class="alert alert-primary d-flex align-items-center border-0" role="alert">
                    <i data-feather="smile" class="me-3"></i>
                    <p class="m-0">
                        jangan lupa <strong>tutup buku</strong> ya!
                    </p>
                </div>
            </div>
        @endif

        <nav id="nav-bottom" class="navbar navbar-expand-lg bg-light fixed-bottom py-2 px-3 shadow" style="height: 75px !important;">
            <div class="d-flex justify-content-around w-100 align-items-center">
                @foreach (config('menu') as $value)
                    <a  href="{{ $value['route'] == '' ? '#' : route($value['route']) }}"
                        class="text-decoration-none" style="color: {{ Route::current()->getName() == $value['route'] ? '#000000e6' : 'grey' }} !important">
                        <i data-feather="{{ $value['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </nav>

        <div class="container p-3 vh-100 px-0 bg-white">
            @yield('content')
            <div id="padding-bottom">
                <br><br><br><br><br><br>
            </div>
            <br><br><br><br><br>
        </div>

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
            function alert(type,title =''){
                Swal.fire({
                    title: title,
                    icon: type,
                })
            }
        </script>
        @yield('script')
    </body>
</html>
