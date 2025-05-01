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
<div class="w-100 vh-100 d-flex align-items-end bg-dark"
    style="
        background-image: url('{{ asset('app-assets/images/bg-login.png') }}');
        object-position: center top;
        background-repeat: no-repeat;
        background-size: 100% auto;
    "
    >
    <div class="w-100">
        <div class="text-center my-4">
            <img src="{{ asset('app-assets/images/logo-pizza.png') }}" style="width: 100px" alt="" class="mb-5">
            <br><br><br><br>
            {{-- <div class="d-flex justify-content-center"><p class="mb-1 text-dark bg-white px-2 rounded-4">Selamat datang</p></div> --}}
            <p class="fw-bold text-warning text-title">Pizza Super <br> Merchant</p>
        </div>
        <br>
        <div class="w-100 p-4 bg-white" style="border-radius: 20px 20px 0px 0px !important">
            <div class="mb-4">
                <p class="fs-3 fw-bold mb-0">Masuk</p>
                {{-- <small class="text-gray">masukkan nomor telepon dan kata sandi untuk <br> masuk ke aplikasi, Have a nice day!</small> --}}
            </div>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="form-group mb-4">
                    <input type="number" class="form-control rounded-4 w-100" value="" name="phone" id="phone" placeholder="nomor telepon" autofocus required>
                </div>
                <div class="form-group mb-4">
                    <input type="password" class="form-control rounded-4 w-100" value="" name="password" id="password" placeholder="kata sandi" required>
                </div>
                {{-- <div class="text-end fw-bold text-gray">
                    Lupa kata sandi?
                </div> --}}
                <br>
                <button type="submit" class="btn btn-warning w-100 rounded-4 py-3 mb-5">Masuk</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('includes.alert')
@endsection
