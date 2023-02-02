@extends('layouts.app')

@section('css')
<style>

</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="px-4 mb-3">
    <h4 class="fw-bold mb-4">{{ $page }}</h4>
    @include('includes.alert')
    <div class="row w-100 m-0 p-0 mt-3 mb-2">
        <div class="col-auto p-0">
            <div class="bg-warning d-flex justify-content-center align-items-center fw-bolder" style="width: 50px !important;height: 50px !important;border-radius:100% !important">
                P
            </div>
        </div>
        <div class="col-auto">
            <p class="mb-0 fw-bold">Pizza Super Sidoarjo</p>
            <p class="fs-6">081216552199</p>
            <p class="badge bg-light-warning fw-bold py-3 px-4 rounded-4">Pegawai</p>
        </div>
    </div>
</div>

<div class="px-4">
    <p class="fs-7 px-0 fw-bold">Stok & Gudang</p>
    @foreach ($menu as $value)
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
        <hr style="opacity: 0.05 !important">
    @endforeach
</div>
@endsection

@section('script')
<script></script>
@endsection
