@extends('layouts.master')

@section('css')
<style>
    .container{
        padding-top:0px !important;
    }
    #padding-bottom {
        padding-bottom: 30vh !important
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
    <a href="{{ route('home.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-0">{{ $page }}</h4>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<nav id="button-calculate" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="py-2 px-3 w-100">
        <div class="p-2">
            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <p class="mb-1">Total Biaya</p>
                        </div>
                        <div class="col-7">
                            <p class="mb-1 text-end">
                                IDR {{ numberFormat($calculate['total_bahan'],0) }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p class="mb-1">Biaya Pengantaran</p>
                        </div>
                        <div class="col-7">
                            <p class="mb-1 text-end">
                                IDR {{ numberFormat($calculate['total_pengiriman'],0) }}
                            </p>
                        </div>
                    </div>
                    <hr style="opacity: 0.05 !important">
                    <div class="row">
                        <div class="col-5">
                            <p class="mb-1">Estimasi Total</p>
                        </div>
                        <div class="col-7">
                            <p class="mb-1 fs-3 text-end fw-semibold">
                                IDR {{ numberFormat($calculate['grand_total'],0) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-5 pe-0">
                <a
                    href="{{ route('restock.index') }}"
                    type="button"
                    class="btn btn-dark text-white w-100 rounded-4 py-3"
                >
                    Reset
                </a>
            </div>
            <div class="col-7">
                <button
                    type="button"
                    class="btn btn-warning text-white rounded-4 py-3 w-100"
                    onclick="calculate()"
                >
                    <span class="ms-2 fw-bold">Hitung</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<div class="px-4 mt-4">
    <div class="alert text-dark rounded-4 w-100 d-flex"
        style="background: #a7a7a731 !important">
        <i data-feather="alert-triangle"></i>
        <span class="ms-3">
            Pastikan mengisi jumlah sesuai kebutuhan restock
        </span>
    </div>
    @php
        $material_id    = $checkpoint['material_id'] ?? [];
        $qty            = $checkpoint['qty'] ?? [];

        $qty_dummy      = 0;
    @endphp
    <form action="{{ route('restock.calculate') }}" method="POST" id="form">
        @csrf
        @foreach ($material as $key => $item)
            @php
                $get_index_by_id = array_search($item->id, $material_id);
                try {
                    $qty_dummy = $qty[$get_index_by_id];
                } catch (\Throwable $th) {
                    $qty_dummy = 0;
                }
            @endphp

            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-5">
                            <p class="fw-bold fs-6 m-0 text-capitalize">{{ $item->name }}</p>
                            <div class="d-flex">
                                <p class="m-0">IDR {{ numberFormat($item->price,0) }}</p>
                            </div>
                            <input type="hidden" name="material_id[]" value="{{ $item->id }}">
                        </div>
                        <div class="col-7 d-flex align-items-center justify-content-around">
                            <button
                                class="btn btn-dark rounded-3 text-white"
                                onclick="minus('{{ $key }}')"
                                style="width: 40px;height: 40px"
                                type="button"
                                id="min{{ $key }}"
                            >
                                <i data-feather="minus" style="width: 12px"></i>
                            </button>
                            <input
                                class="form-control text-center rounded-3"
                                name="qty[]" id="qty{{ $key }}"
                                style="width: 70px; padding: 5px !important; height: 45px !important"
                                value="{{ $qty_dummy }}"
                                type="number"
                            >
                            <button
                                class="btn btn-warning rounded-3 text-white"
                                onclick="plus('{{ $key }}')"
                                style="width: 40px;height: 40px"
                                type="button"
                                id="min{{ $key }}"
                            >
                                <i data-feather="plus" style="width: 12px"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <button class="d-none" id="btn-submit" type="submit"></button>
    </form>
</div>

<div class="px-4">
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        // $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });

    function calculate() {
        $('#btn-submit').click();
        console.log('calculate');
    }

    function minus(key){
        var qty_text = parseInt($('#qty'+key).val())
        if(qty_text > 0){
            $('#qty'+key).val(qty_text-1)
            // $('#qty'+key).val(parseInt($('#qty'+key).val()))
        }
    }
    function plus(key){
        var qty_text = parseInt($('#qty'+key).val())
        $('#qty'+key).val(qty_text+1)
        // $('#qty'+key).val(parseInt($('#qty'+key).val()))
    }
</script>
@endsection
