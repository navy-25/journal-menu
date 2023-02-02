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
    <h4 class="fw-bold mb-4">{{ config('app.name') }}</h4>
    @include('includes.alert')

    <div class="card rounded-4 border-0 mb-4"
        style="box-shadow:5px 4px 30px rgba(53, 53, 53, 0.288);
            background-image:url('app-assets/images/card-bg.jpg');
            background-repeat: no-repeat;
            background-position: right top;
            background-size: cover;
        ">
        <div class="card-body p-4 text-white">
            <p class="fs-5 mb-0">Total Pendapatan</p>
            <p class="mb-3 fs-3 fw-bold d-flex align-items-center">
                IDR {{ numberFormat($data['all']) }}
            </p>
            <p class="fs-6 mb-0">Total Pizza </p>
            <p class="m-0 fs-5 fw-bold d-flex align-items-center">
                <i data-feather="shopping-bag" class="me-2" style="width: 15px"></i>
                {{ numberFormat($data['qty']) }} terjual
            </p>
        </div>
    </div>
</div>
<br>
<div class="px-4">
    <div class="row px-0 mb-3">
        <div class="col-6 d-flex align-items-center">
            <h6 class="fw-bold">Detail harian</h6>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalIncome">Lihat semua</a>
        </div>
    </div>
    @php
        $index = 1;
    @endphp
    @foreach ($data['weekly'] as $key => $value)
        @php
            $total  = 0;
            foreach ($value as $item) {
                $total += ($item->qty * $item->price);
            }
            if($index == 4){
                break;
            }
        @endphp
        <div class="row">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                {{ formatDay($key) }}, {{ customDate($key,'d M') }}
            </div>
            <div class="col-6 d-flex justify-content-end">
                <p class="m-0 fw-bold text-success">+ IDR {{ numberFormat($total) }}</p>
            </div>
        </div>
        <hr class="py-1 my-2" style="opacity: 0.05 !important">
        @php
            $index++
        @endphp
    @endforeach
</div>
<br>
<div class="px-4">
    <div class="row px-0 mb-3">
        <div class="col-6 d-flex align-items-center">
            <h6 class="fw-bold">Berdasarkan menu</h6>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalMenu">Lihat semua</a>
        </div>
    </div>
    @php
        $index = 1;
    @endphp
    @foreach ($data['menu'] as $key => $value)
        @php
            if($index == 4){
                break;
            }
        @endphp
        <div class="row">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <i data-feather="package" class="me-2" style="width: 15px"></i>
                {{ $value->name }}
            </div>
            <div class="col-6 d-flex justify-content-end">
                <p class="m-0 fw-bold text-success">+ {{ numberFormat($value->total_terjual) }}</p>
            </div>
        </div>
        <hr class="py-1 my-2" style="opacity: 0.05 !important">
        @php
            $index++
        @endphp
    @endforeach
</div>
<br>
<div class="px-4">
    <div class="row px-0 mb-3">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold">Berdasarkan shift</h6>
        </div>
    </div>
    @foreach ($shift as $key => $value)
        <div class="row">
            <div class="col-4 d-flex justify-content-start align-items-top">
                <i data-feather="users" class="me-2" style="width: 15px"></i>
                <b>Shift {{ ++$key }} </b><br>
            </div>
            <div class="col-4 d-flexjustify-content-start align-items-top">
                {{ implode(' s/d ', $value['shift']) }}
            </div>
            <div class="col-4 d-flex justify-content-end">
                <p class="m-0 fw-bold text-dark">
                    {{ numberFormat($value['total_pembeli']) }} pizza
                </p>
            </div>
        </div>
        <hr class="py-1 my-2" style="opacity: 0.05 !important">
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="modalIncome" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalIncomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark me-3">
                    <i data-feather="arrow-left" style="width: 18px"></i>
                </a>
                <p class="fs-6 m-0 fw-bold">Detail pemasukann harian</p>
            </div>
            <div class="modal-body">
                @foreach ($data['weekly'] as $key => $value)
                    @php
                        $total  = 0;
                        foreach ($value as $item) {
                            $total += ($item->qty * $item->price);
                        }
                    @endphp
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-center">
                            <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                            {{ formatDay($key) }}, {{ customDate($key,'d M') }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <p class="m-0 fw-bold text-success">+ IDR {{ numberFormat($total) }}</p>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalMenu" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark me-3">
                    <i data-feather="arrow-left" style="width: 18px"></i>
                </a>
                <p class="fs-6 m-0 fw-bold">Detail penjualan by menu</p>
            </div>
            <div class="modal-body">
                @foreach ($data['menu'] as $key => $value)
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-center">
                            <i data-feather="package" class="me-2" style="width: 15px"></i>
                            {{ $value->name }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <p class="m-0 fw-bold text-success">+ {{ numberFormat($value->total_terjual) }}</p>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script></script>
@endsection
