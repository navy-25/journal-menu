@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert border-0 alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ ucfirst($error) }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach
@endif
@if ($message = Session::get('success'))
    <div class="alert border-0 alert-warning alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ $message }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert border-0 alert-dark alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ $message }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
