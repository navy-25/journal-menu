
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            $list_error [] = ucfirst($error);
        @endphp
        {{-- <div class="alert border-0 alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ ucfirst($error) }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}
    @endforeach
    <script>
        Swal.fire({
            title:"Gagal!",
            text: "{{ join(', ',$list_error) }}",
            icon: "error",
            timer: "1000",
        })
    </script>
@endif
@if ($message = Session::get('success'))
    {{-- <div class="alert border-0 alert-warning alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ $message }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ $message }}",
            icon: "success",
            timer: "1000",
        })
    </script>
@endif
@if ($message = Session::get('error'))
    {{-- <div class="alert border-0 alert-dark alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ $message }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div> --}}
    <script>
        Swal.fire({
            title: "Gagal!",
            text: "{{ $message }}",
            icon: "error",
            timer: "1000",
        })
    </script>
@endif
