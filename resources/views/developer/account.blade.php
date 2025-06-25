@extends('layouts.dev')

@section('css')
<style>
    .container{
        padding-top:0px !important;
    }
</style>
@endsection

@section('content')
@php

@endphp
{{-- NAV BACK --}}
<div class="px-4 py-4 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('dev.settings.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<div class="px-4 mb-3">
    @include('includes.alert')
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Pengaturan {{ $page }}</h6>
        </div>
    </div>
</div>
<div class="px-4">
    <form action="{{ route('dev.account.update') }}" method="post" id="form">
        @csrf
        <div class="form-group mb-3">
            <label for="" class="mb-2">Username</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
        </div>
        <div class="form-group mb-3">
            <label for="" class="mb-2">Nomor telepon</label>
            <input type="number" class="form-control" name="phone" value="{{ Auth::user()->phone }}" placeholder="ex. 08xx xxx xxxx" required>
        </div>
        <div class="form-group mb-3">
            <label for="" class="mb-2">Pemilik outlet</label>
            <input type="text" class="form-control" name="owner" value="{{ Auth::user()->owner }}" placeholder="ex. nama terang" required>
        </div>
        <div class="form-group mb-3">
            <label for="" class="mb-2">Alamat outlet</label>
            <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" placeholder="ex. dsn/ds/kec/kab/nama jalan" required>
        </div>
        <br>
        <button type="submit" class="btn btn-dark w-100 rounded-4 py-3">Simpan</button>
    </form>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });
</script>
@endsection
