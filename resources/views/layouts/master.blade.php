<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page }} - {{ config('app.name') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('app-assets/images/logo-pizza.webp') }}">

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
            .form-control{
                padding: 1rem 1.4rem !important;
                height: 60px !important;
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
        {{-- @if (date('H:i') > '22:00' && date('H:i') < '23:59')
            @php
                $is_closed = DB::table('transactions')->where('date', date('Y-m-d'))->where('id_user', getUserID())->where('type', 9)->count();
            @endphp
            @if ($is_closed == 0)
                <div id="reminder" style="position: fixed;bottom:150px;z-index:999;margin-left:10px">
                    <div class="alert alert-primary text-center d-block border-0 rounded-4" style="box-shadow: 0px 0px 20px 0px #b9b9b9 !important;" role="alert">
                        <i data-feather="smile" style="width: 40px;height: 40px;" class="mb-3"></i>
                        <p class="m-0 text-small">
                            Jangan lupa <br> <strong>tutup buku</strong>
                        </p>
                    </div>
                </div>
            @endif
        @endif --}}

        <nav id="nav-bottom" class="navbar navbar-expand-lg fixed-bottom mb-2" style="height: fit-content !important;">
            <div class="py-2 px-3 w-100">
                <div class="d-flex justify-content-around w-100 align-items-center bg-white rounded-4" style="box-shadow: 0px 0px 20px 0px #b9b9b9 !important;">
                    @foreach (config('menu') as $value)
                        <a
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $value['name'] }}"
                            href="{{ $value['route'] == '' ? '#' : route($value['route']) }}"
                            class="text-decoration-none d-flex align-items-center justify-content-center py-4 pb-0"
                            style="
                                color: {{ Route::current()->getName() == $value['route'] ? '#ff5e00' : 'grey' }} !important;
                            ">
                            <center>
                                <i class="mb-3" data-feather="{{ $value['icon'] }}"></i>
                                <div class="{{ Route::current()->getName() == $value['route'] ? 'bg-warning' : 'bg-transparent' }} rounded-pill mb-2" style="width: 40px; height: 5px"></div>
                            </center>
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <div class="container p-3 px-0" style="min-height: 100vh">
            @yield('content')
            <div class="bg-body w-100" id="padding-bottom" style="height: 150px"></div>
        </div>

        <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
        @include('includes.globalJs')

        <script>
            let startY = 0;
            let isPulled = false;

            window.addEventListener('touchstart', function(e) {
                if (window.scrollY === 0) {
                    startY = e.touches[0].clientY;
                    isPulled = true;
                }
            });

            window.addEventListener('touchmove', function(e) {
                if (!isPulled) return;

                let currentY = e.touches[0].clientY;
                if (currentY - startY > 250) { // jika ditarik lebih dari 80px
                    isPulled = false;
                    location.reload(); // reload halaman
                }
            });

            window.addEventListener('touchend', function() {
                isPulled = false;
            });
            </script>

        @yield('script')
    </body>
</html>
