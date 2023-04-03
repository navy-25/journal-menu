@extends('layouts.master')

@section('css')
<style>
    #padding-bottom{
        display: none;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="px-4 mb-3">
    <h4 class="fw-bold mb-4">{{ Auth::user()->name }}</h4>
    @include('includes.alert')
    <div class="card rounded-4 border-0 mb-4 bg-white shadow-mini"
        style="
            background-image:url('app-assets/images/card-bg.jpg');
            background-repeat: no-repeat;
            background-position: right top;
            background-size: cover;"
        >
        <div class="card-body p-4 text-white">
            <div class="row mb-2">
                <div class="col-12 mb-3">
                    <p class="mb-1">Bulan {{ month((int)date('m')) }}</p>
                    <p class="mb-0 fs-4 fw-bold d-flex align-items-center text-warning">
                        IDR {{ numberFormat($data['month'],0) }}
                    </p>
                </div>
                <div class="col-12">
                    <p class="mb-1">Keseluruhan</p>
                    <p class="mb-0 fs-4 fw-bold d-flex align-items-center text-warning">
                        IDR {{ numberFormat($data['all'],0) }}
                    </p>
                </div>
            </div>
            <hr style="opacity: 0.05 !important">
            <small class="d-flex align-items-center">
                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                {{ customDate($dates['dateStartFilter'],'d') }} s/d {{ dateFormat($dates['dateEndFilter']) }}
            </small>
        </div>
    </div>
</div>
<div class="px-4">
    <p class="fw-bold mb-3">Pintasan</p>
    <div class="row">
        @foreach ($menu as $value)
            <div class="col-4 d-flex justify-content-center align-items-center mb-4">
                <a href="{{ $value['route'] == '' ? '#' : route($value['route']) }}"
                    class="text-decoration-none text-white text-center px-3 py-4 d-block bg-dark border-0 w-100 rounded-5"
                    style="
                        background-image:url('app-assets/images/card-bg-empty.jpg');
                        background-repeat: no-repeat;
                        background-position: right top;
                        background-size: cover;"
                    >
                    <i class="mb-2" data-feather="{{ $value['icon'] }}" width="25px"></i>
                    <p class="fs-7 mb-0 fw-bold">{{ $value['name'] }}</p>
                </a>
            </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="filter" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Filter by tanggal</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('stats.index') }}" method="get">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal awal</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter">
                        </div>
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal akhir</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateEndFilter'] }}"
                            name="dateEndFilter">
                        </div>
                    </div>
                    <button class="d-none" id="btn-submit-filter" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" onclick="$('#btn-submit-filter').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3">Terapkan</button>
            </div>
        </div>
    </div>
</div>
@endsection
