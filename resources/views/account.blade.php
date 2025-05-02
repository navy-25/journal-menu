@extends('layouts.master')

@section('css')
<style>
    .container{
        padding-top:0px !important;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
@include('includes.alert')
{{-- NAV BACK --}}
<div id="nav-top" class="px-4 py-3 mb-3 fixed-top d-flex align-items-center justify-content-between bg-body-blur">
    <a href="{{ route('settings.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-0">{{ $page }}</h4>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<div class="px-4 mt-4">
    <form action="{{ route('account.update') }}" method="post" id="form">
        @csrf
        <div class="form-group mb-3">
            <label for="" class="form-label opacity-75 text-small">Cabang</label>
            <input type="text" class="form-control rounded-4" value="{{ Auth::user()->name }}" disabled>
        </div>
        <div class="form-group mb-3">
            <label for="" class="form-label opacity-75 text-small">Nomor telepon</label>
            <input type="number" class="form-control rounded-4" name="phone" value="{{ Auth::user()->phone }}" placeholder="ex. 08xx xxx xxxx" autofocus required>
        </div>
        <div class="form-group mb-3">
            <label for="" class="form-label opacity-75 text-small">Pemilik outlet</label>
            <input type="text" class="form-control rounded-4" name="owner" value="{{ Auth::user()->owner }}" placeholder="ex. nama terang" required>
        </div>
        <div class="form-group mb-3">
            <label for="" class="form-label opacity-75 text-small">Alamat outlet</label>
            <input type="text" class="form-control rounded-4" name="address" value="{{ Auth::user()->address }}" placeholder="ex. dsn/ds/kec/kab/nama jalan" required>
        </div>
        <br>
        <button type="submit" id="btn-submit" class="btn btn-warning text-white w-100 rounded-4 py-3">Simpan</button>
    </form>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });
    document.getElementById("form").addEventListener("submit", function (e) {
        // e.preventDefault();
        const btn = document.getElementById("btn-submit");
        btn.disabled = true;
    });
</script>
@endsection
