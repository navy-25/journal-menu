@extends('layouts.master')

@section('css')
<style>

</style>
@endsection

@section('content')
@php

@endphp
<div class="px-4 mb-4">
    {{-- <h4 class="fw-bold mb-4">{{ $page }}</h4>
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
    </div> --}}
    <a href="{{ route('home.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1; margin-bottom: 10%">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-4">{{ $page }}</h4>
</div>

<div class="px-4">
    @if (isOwner())
        <div class="card bg-white text-dark rounded-4 border-0 mb-4">
            <div class="card-body">
                <p class="text-small px-0 fw-bold mb-4 text-dark">Stok & Gudang</p>
                @foreach ($stock_menu as $index => $value)
                    @if ($index > 0)
                    <hr style="opacity: 0.05 !important">
                    @endif
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
                @endforeach
            </div>
        </div>
    @endif
    <div class="card bg-white text-dark rounded-4 border-0 mb-4">
        <div class="card-body">
            <p class="text-small px-0 fw-bold mb-4 text-dark">Data Akun</p>
            @foreach ($account as $index => $value)
                @if ($index > 0)
                <hr style="opacity: 0.05 !important">
                @endif
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
            @endforeach
        </div>
    </div>
    <div class="card bg-white text-dark rounded-4 border-0 mb-4">
        <div class="card-body">
            <p class="text-small px-0 fw-bold mb-4 text-dark">Lainnya</p>
            @foreach ($more as $index => $value)
                @if ($index > 0)
                <hr style="opacity: 0.05 !important">
                @endif
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
            @endforeach
        </div>
    </div>
    {{-- <button type="button" onclick="alert_confirm('{{ route('login.logout') }}','Yakin keluar?')" class="btn btn-danger w-100 rounded-4 py-3 mt-2">Keluar</button> --}}
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
