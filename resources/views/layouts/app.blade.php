<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page }} {{ config('app.name') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('logo-pizza.png') }}">

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
        <script src="{{ asset('js/feather-icons.js') }}"></script>

        @yield('css')
        <style>
            .form-select:focus {
                border-color: #00000018 !important;
                outline: 0 !important;
                box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 0%) !important;
            }
            .swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation {
                background: rgb(0 0 0 / 71%) !important;
            }
            .swal2-styled.swal2-confirm {
                background-color: #323232 !important;
                border-radius: 15px !important;
            }
            .swal2-styled.swal2-confirm:focus, .swal2-styled.swal2-cancel:focus {
                box-shadow: 0 0 0 3px rgb(112 102 224 / 0%) !important;
            }
            .swal2-styled.swal2-cancel {
                background-color: #ffffff00 !important;
                color: #3c3c3c !important;
                border-radius: 15px !important;
            }
            .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
                background-image: linear-gradient(rgb(0 0 0 / 4%), rgb(0 0 0 / 4%)) !important;
            }
            .swal2-popup {
                width: 70vw !important;
                padding: 30px !important;
                border-radius: 30px !important;
            }
            .form-control:focus {
                border-color: #3a3a3a38 !important;
                box-shadow: 0 0 0 0.25rem rgb(98 98 98 / 0%) !important;
            }
            .swal2-title {
                padding: 25px 0px !important;
            }
            .bg-light-dark{
                background: rgba(43, 43, 43, 0.1) !important;
                color: rgb(43, 43, 43) !important;
            }
            .bg-light-warning{
                background: rgba(255, 138, 4, 0.1) !important;
                color: rgb(255, 155, 4) !important;
            }
            .bg-light-danger{
                background: rgba(255, 12, 4, 0.1) !important;
                color: rgb(255, 4, 4) !important;
            }
            .shadow{
                box-shadow: 0px 30px 50px !important;
            }
            .shadow-mini{
                box-shadow: 0px 0px 30px rgba(58, 58, 58, 0.144)
            }
            .modal-dialog-bottom{
                position: fixed !important;
                margin: 0px !important;
                width: 100% !important;
                bottom: 0px !important;
                border-radius: 20px 20px 0px 0px !important;
            }
            .modal-content-bottom{
                border-radius: 20px 20px 0px 0px !important;
            }
            .rounded-5{
                border-radius: 15px !important
            }
            /* spinner */
            #spinner{
                position: fixed;
                z-index: 9999999;
                height: 100vh;
                background: rgb(255, 255, 255);
                width: 100vw !important;
                padding-top: 40vh
            }
        </style>
    </head>
    <body>
        <div id="spinner" class="bg-white">
            <center>
                <div class="loadingio-spinner-bean-eater-ybl8jhu3zcq">
                    <div class="ldio-63eo66kwxha">
                        <div><div></div><div></div><div></div></div><div><div></div><div></div><div></div></div>
                    </div>
                </div>
            </center>
        </div>

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
            <div id="padding-bottom"><br><br><br><br><br></div>
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
                    title: 'Hapus '+title+'?',
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
