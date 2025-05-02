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
    <div style="position: fixed;bottom:70px;right:20px;">
        <button type="button" class="btn btn-warning text-dark d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%" onclick="create()">
            <i data-feather="plus" style="width: 25px" data-bs-toggle="modal" data-bs-target="#modal"></i>
        </button>
    </div>
    @include('includes.alert')
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Pengaturan {{ $page }}</h6>
        </div>
    </div>
</div>
<div class="px-4">
    <form action="{{ route('dev.account.updatePassword') }}" method="post" id="form">
        @csrf
        <div class="form-group mb-3">
            <label for="" class="mb-2">Kata sandi baru</label>
            <input type="password" class="form-control" name="password" placeholder="kata sandi baru" required>
        </div>
        <div class="form-group mb-3">
            <label for="" class="mb-2">Ulangi</label>
            <input type="password" class="form-control" name="retype_password" placeholder="ulangi kata sandi baru" required>
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
