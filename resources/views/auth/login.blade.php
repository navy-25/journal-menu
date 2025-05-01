@extends('layouts.app')

@section('css')
<style>
    .form-control{
        padding: 1rem 1.4rem !important;
        height: 60px !important;
    }
    .text-title{
        font-size: 45px;
        line-height: 40px;
    }
</style>
@endsection

@section('content')
<div class="w-100 vh-100 d-flex align-items-start">
    <div class="w-100 p-4">
        <a href="/" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1; margin-bottom: 30%">
            <i data-feather="chevron-left"></i>
        </a>
        <div class="mb-4">
            <p class="fs-3 fw-bold mb-1">Sign in</p>
            <p class="text-small text-gray">Masukkan nomor telepon dan kata sandi untuk <br> masuk ke aplikasi, Have a nice day!</p>
        </div>
        <form id="form" method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="form-group mb-3">
                <p class="form-label opacity-75 text-small">Phone<span class="text-danger">*</span> </p>
                <input type="number" class="form-control border-0 rounded-4 w-100" value="" name="phone" id="phone" placeholder="085 xxxx xxxx" autofocus required>
            </div>
            <div class="form-group mb-3">
                <p class="form-label opacity-75 text-small">Password<span class="text-danger">*</span> </p>
                <input type="password" class="form-control border-0 rounded-4 w-100" value="" name="password" id="password" placeholder="*****************" required>
            </div>
            <br>
            <button type="submit" id="btn-submit" class="btn btn-warning w-100 rounded-4 py-3 mb-5">Let's Go!</button>
        </form>
        <p class="text-gray text-center text-small">Jika terdapat kendala silahkan hubungi admin</p>
    </div>
</div>
@endsection

@section('script')
@include('includes.alert')

<script>
    document.getElementById("form").addEventListener("submit", function (e) {
        // e.preventDefault();
        const btn = document.getElementById("btn-submit");
        btn.disabled = true;
    });
</script>
@endsection
