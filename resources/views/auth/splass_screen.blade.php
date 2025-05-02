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
    body {
        background: white !important
    }
</style>
@endsection

@section('content')
<div class="w-100 vh-100 d-block">
    <div class="bg-warning d-flex align-items-center justify-content-center" style="height: calc(100% - 45%); border-radius: 0px 0px 50px 50px">
        <img class="w-100" src="{{ asset('app-assets/images/pizza-ilust.webp') }}" alt="">
    </div>
    <div class="w-100 px-4 py-5 bg-white" style="height: 45%;">
        <div class="mb-4">
            <p class="fs-2 fw-bold">Selalu ada alasan untuk sepotong lagi.</p>
            <p class="text-gray mb-5">Temani tawa, cerita, dan waktu berharga bersama keluarga.</p>
            <a href="{{ route('login.form') }}" class="btn btn-warning w-100 rounded-4 py-3 mb-5">Sign in</a>
        </div>
    </div>
</div>
@endsection

@section('script')
@include('includes.alert')
@endsection
