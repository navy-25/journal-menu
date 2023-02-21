@extends('layouts.app')

@section('css')
<style>
    .accordion-item {
        border: rgba(255, 255, 255, 0) !important;
    }
    .accordion {
        --bs-accordion-bg: #fff0 !important;
    }
    .accordion-button:not(.collapsed)::after {
        filter: grayscale(1) !important;
    }
    .accordion-button:focus {
        /* border-color: #86b7fe00 !important; */
        box-shadow: none !important;
    }
    .accordion-button:not(.collapsed) {
        color: #212529 !important;
        background-color: #33333300 !important;
        box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 #dee2e600 !important;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="px-4 mb-3">
    <div style="position: fixed;bottom:120px;right:20px;">
        <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%">
            <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
        </button>
    </div>
    <h4 class="fw-bold mb-4">
        {{ $page }}
        {{ dateFormat($dates['dateStartFilter']) }} s/d {{ dateFormat($dates['dateEndFilter']) }}
    </h4>
    @include('includes.alert')
</div>

<div class="px-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-6">
                    <p class="m-0">Total pizza</p>
                    <p class="fw-bold fs-5">{{ numberFormat($qty) }} pizza</p>
                    <p class="m-0">Total Pesanan</p>
                    <p class="fw-bold fs-5">{{ count($data) }} pesanan</p>
                </div>
                <div class="col-6">
                    <p class="m-0">Total Laba Kotor</p>
                    <p class="fw-bold fs-5">IDR {{ numberFormat($total) }}</p>
                    <p class="m-0">Asumsi Laba Bersih (40%)</p>
                    <p class="fw-bold fs-5">IDR {{ numberFormat((40/100)*$total) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h6 class="fw-bold mb-2">Daftar pesanan</h6>
            @if (count($data) == 0)
                <div class="py-5">
                    <center>
                        <img src="{{ asset('app-assets/images/shopping-bag.png') }}" alt="wallet" class="mb-3" width="30%">
                        <br>
                        <p class="fw-bold fs-4 text-secondary">
                            Belum ada pesanan <br> hari ini
                        </p>
                    </center>
                </div>
            @else
                @php
                    $index = count($data);
                @endphp
                @foreach ($data as $key => $val)
                    <div class="accordion p-3 mb-3" id="accordion_{{ $key }}" style="border: 1px solid #2125291e;border-radius:15px">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{$key}}">
                                <button class="accordion-button collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="false" aria-controls="collapse_{{$key}}">
                                    <p class="fw-bold m-0 mb-2 me-2">Pesanan ke {{ $index }}</p>
                                    <p class="fw-bold m-0 mb-2" id="total_order_{{$key}}">IDR 0</p>
                                </button>
                            </h2>
                            @php
                                $date = '';
                                $total = 0;
                                $note = '';
                            @endphp
                            <div id="collapse_{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading_{{$key}}" data-bs-parent="#accordion">
                                <div class="accordion-body p-0 pt-2">
                                    @foreach ($val as $item)
                                        <div class="row mb-2">
                                            <div class="col-1">
                                                -
                                            </div>
                                            <div class="col-11">
                                                <p class="mb-0 text-capitalize">{{ $item->name }}</p>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="mb-0">{{ numberFormat($item->price) }} @ {{ $item->qty }} </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0 text-end">IDR {{ numberFormat($item->price*$item->qty) }} </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $total += $item->price*$item->qty;
                                            $date = $item->created_at;
                                            $note = $item->note;
                                        @endphp
                                    @endforeach
                                    <p class="fw-bold text-end mb-3">IDR {{ numberFormat($total) }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center pt-2">
                                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                                <small>{{ date('d M Y H:i', strtotime($date)) }}</small>

                                <a href="#" class="text-dark ms-auto text-decoration-none me-4"  data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="note('{{ $note }}')">Catatan</a>
                                <a href="#" class="text-danger text-decoration-none" onclick="alert_confirm('{{ route('sales.destroy',['id'=>$key]) }}','Hapus pesanan ke {{ $index }}')">Hapus</a>
                            </div>

                            <script>
                                setTimeout(() => {
                                    $('#total_order_{{$key}}').text('(IDR {{ numberFormat($total) }})')
                                }, 100);
                            </script>
                        </div>
                    </div>
                    @php
                        $index--;
                    @endphp
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="filter" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Filter by tanggal</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.show') }}" method="get">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal awal</label>
                            <input type="date" class="form-control" style="height: 50px !important"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter">
                        </div>
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal akhir</label>
                            <input type="date" class="form-control" style="height: 50px !important"
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

@section('script')
<script></script>
@endsection
