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

@endphp
{{-- NAV BACK --}}
<div id="nav-top" class="px-4 py-3 mb-3 fixed-top d-flex align-items-center justify-content-between bg-body-blur">
    <a href="{{ route('home.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-0">{{ $page }}</h4>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

{{-- <div class="px-4 mb-2 mt-4">
    <div class="row px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div> --}}

<nav id="button-create" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="pb-2 pt-3 px-3 w-100">
        <div class="d-flex justify-content-end w-100 align-items-center rounded-4 p-2">
            <button
                type="button"
                class="btn btn-warning text-white rounded-4 py-3 w-100"
                data-bs-toggle="modal" data-bs-target="#filter"
            >
                <span class="ms-2 fw-bold">Filter</span>
            </button>
        </div>
    </div>
</nav>
{{--
@if (isOwner())
    <div style="position: fixed;bottom:100px;right:20px;z-index:999">
        <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%">
            <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
        </button>
    </div>
@endif --}}

{{-- NAV BOTTOM --}}
{{-- <nav id="nav-bottom" class="navbar navbar-expand-lg bg-white fixed-bottom px-3" style="height: 100px !important;">
    <form action="{{ route('report.download') }}" method="POST" class="d-none">
        @csrf
        <div class="row">
            <div class="col-6 mb-3">
                <label for="" class="mb-2">Tanggal awal</label>
                <input type="date" class="form-control"
                value="{{ $dates['dateStartFilter'] }}"
                name="dateStartFilter">
            </div>
            <div class="col-6 mb-3">
                <label for="" class="mb-2">Tanggal akhir</label>
                <input type="date" class="form-control"
                value="{{ $dates['dateEndFilter'] }}"
                name="dateEndFilter">
            </div>
        </div>
        <button class="d-none" id="btn-submit-download" type="submit"></button>
    </form>
    <button type="button" class="btn btn-warning rounded-4 py-3 px-4 w-100 fw-bold" onclick="$('#btn-submit-download').trigger('click');" >Unduh laporan</button>
</nav> --}}
{{-- END NAV BOTTOM --}}

<div class="px-4 mb-3 mt-3">
    @include('includes.alert')
    <div class="px-2">
        <div class="row mb-4">
            {{-- <div class="col-6">
                <small class="m-0 d-flex align-items-center">
                    <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                    Tgl. Awal
                </small>
                <p class="fw-bold fs-6 mb-0">{{ dateFormat($dates['dateStartFilter']) }}</p>
            </div>
            <div class="col-6">
                <small class="m-0 d-flex align-items-center">
                    <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                    Tgl. Akhir
                </small>
                <p class="fw-bold fs-6 mb-0">{{ dateFormat($dates['dateEndFilter']) }}</p>
            </div> --}}

            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="m-0 d-flex align-items-center">
                                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                                Tgl. Awal
                            </small>
                            <p class="fw-bold fs-6 mb-0">{{ dateFormat($dates['dateStartFilter']) }}</p>
                        </div>
                        <div class="col-6">
                            <small class="m-0 d-flex align-items-center">
                                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                                Tgl. Akhir
                            </small>
                            <p class="fw-bold fs-6 mb-0">{{ dateFormat($dates['dateEndFilter']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Kuantitas Penjualan</h6>
        </div>
        <div class="col-12">
            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <table id="table-sales" class="table table-borderless table-striped w-100 mx-0">
                        <thead>
                            <tr>
                                <td class="fw-bold">Nama menu</td>
                                <td class="fw-bold">Jumlah</td>
                                <td class="fw-bold">Satuan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $qty_total = 0
                            @endphp
                            @foreach ($sales as  $key => $item)
                                @php
                                    $qty = 0;
                                    foreach ($item as $value) {
                                        $qty += $value->qty;
                                    }
                                @endphp
                                <tr>
                                    <td class=" small">{{ $key }}</td>
                                    <td class=" small">{{ numberFormat($qty,0) }}</td>
                                    <td class=" small">pcs</td>
                                </tr>
                                @php
                                    $qty_total += $qty;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            Jumlah keseluruhan
                        </div>
                        <div class="col-6 fw-bold">
                            {{ numberFormat($qty_total,0) }} pcs
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            Total keseluruhan
                        </div>
                        <div class="col-6 fw-bold">
                            Rp {{ numberFormat($omset,0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Keuangan Outlet</h6>
        </div>
        <div class="col-12">
            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <table id="table-transaction" class="table table-borderless table-striped w-100 mx-0">
                        <thead>
                            <tr>
                                <td class="fw-bold" style="width: 60px">Tgl</td>
                                <td class="fw-bold">Deskripsi</td>
                                <td class="fw-bold" style="width: 100px !important">Jumlah</td>
                                <td class="fw-bold" style="width: 5px !important"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0
                            @endphp
                            @foreach ($transaction as  $key => $item)
                                <tr>
                                    <td class="small">{{ customDate($item->date, 'y/m/d') }}</td>
                                    <td class="small">{{ $item->name }}</td>
                                    <td class="text-end small">
                                        @if($item->status == 'in')
                                            <span>Rp {{ numberFormat($item->price,0) }}</span>
                                        @else
                                            <span class="text-danger">(Rp {{ numberFormat($item->price,0) }})</span>
                                        @endif
                                    </td>
                                    <td class="text-end small">
                                        <div class="d-none">
                                            @if($item->status == 'in')
                                                <span>{{ $item->price }}</span>
                                            @else
                                                <span class="text-danger">-{{ $item->price }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    if($item->status == 'in'){
                                        $total += $item->price;
                                    }else{
                                        $total -= $item->price;
                                    }
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            Total keseluruhan
                        </div>
                        <div class="col-6 fw-bold fs-5 text-end">
                            Rp {{ numberFormat($total,0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
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
                <form action="{{ route('report.index') }}" method="get">
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
                <button type="button" onclick="$('#btn-submit-filter').trigger('click')" class="btn btn-warning text-white w-100 rounded-4 py-3">Terapkan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // $('#padding-bottom').remove();
        $('#nav-bottom').remove();
        $('#table-sales').DataTable({
            paging: false,
            ordering: true,
            order: [[1, 'desc']],
            searching: false,
            info: false,
        });
        $('#table-transaction').DataTable({
            paging: false,
            ordering: true,
            order: [[0, 'desc']],
            searching: false,
            info: false,
            columnDefs: [
                { targets: [2], orderable: false }
            ]
        });
    } );
</script>
@endsection
