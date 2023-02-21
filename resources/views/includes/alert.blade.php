
<script src="{{ asset('js/sweetalert2@11.js') }}"></script>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            $list_error [] = ucfirst($error);
        @endphp
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
    <script>
        Swal.fire({
            title: "Gagal!",
            text: "{{ $message }}",
            icon: "error",
            timer: "1000",
        })
    </script>
@endif
