@extends('layouts.dev')

@section('css')
<style>

</style>
@endsection

@section('content')
@php

@endphp
<div class="px-4 mb-4">
    <h4 class="fw-bold mb-4">{{ $page }}</h4>
    @include('includes.alert')
    <div class="row w-100 m-0 p-0 mt-3 mb-5">
        <div class="col-auto p-0">
            <div class="bg-warning d-flex justify-content-center align-items-center fw-bolder" style="width: 50px !important;height: 50px !important;border-radius:100% !important">
                {{ Auth::user()->name[0] }}
            </div>
        </div>
        <div class="col-auto d-flex align-items-center">
            <div>
                <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                <p class="fs-7 mb-0">{{ Auth::user()->phone }}</p>
            </div>
        </div>
    </div>
</div>

<div class="px-4">
    <p class="fs-7 px-0 fw-bold mb-4 text-gray">Tentang Aplikasi</p>
    @foreach ($account as $value)
        @if ($value['route'] == '#')
            <a class="row text-decoration-none text-dark" href="{{ $value['route'] }}" onclick="alert('info','Sedang dalam pengembangan')">
                <div class="col-8">
                    <div class="px-0 d-flex">
                        <i data-feather="{{ $value['icon'] }}" style="width: 16px" class="my-auto me-3"></i>
                        <span class="my-auto">{{ $value['name'] }}</span>
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <i data-feather="chevron-right" class="my-auto ms-auto" style="width: 18px"></i>
                </div>
            </a>
        @else
            <a class="row text-decoration-none text-dark" href="{{ $value['route'] }}" >
                <div class="col-8">
                    <div class="px-0 d-flex">
                        <i data-feather="{{ $value['icon'] }}" style="width: 16px" class="my-auto me-3"></i>
                        <span class="my-auto">{{ $value['name'] }}</span>
                    </div>
                </div>
                <div class="col-4 d-flex">
                    <i data-feather="chevron-right" class="my-auto ms-auto" style="width: 18px"></i>
                </div>
            </a>
        @endif
        <hr style="opacity: 0.05 !important">
    @endforeach
    <button type="button" onclick="alert_confirm('{{ route('login.logout') }}','Yakin keluar?')" class="btn btn-danger w-100 rounded-4 py-3 mt-2">Keluar</button>
</div>
@endsection

@section('script')
<script></script>
@endsection
