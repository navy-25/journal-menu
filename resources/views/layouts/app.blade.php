<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page }} - {{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
        <script src="{{ asset('js/feather-icons.js') }}"></script>

        @yield('css')
        <style>
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
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-light fixed-bottom py-2 px-3" style="height: 75px !important;box-shadow: 0px 30px 50px;">
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
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>

        <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
        <script>
            $(document).ready( function () {
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
