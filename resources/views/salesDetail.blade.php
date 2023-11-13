@extends('layouts.master')

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

{{-- NAV BACK --}}
<div class="px-4 py-4 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('sales.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<div style="position: fixed;bottom:50px;right:20px;z-index:999">
    <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%">
        <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
    </button>
</div>
<div class="px-4">
    @include('includes.alert')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="row p-3 rounded-4 mb-3" style="background: rgba(140, 140, 140, 0.1)">
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
            <div class="row p-3 rounded-4" style="background: rgba(140, 140, 140, 0.1)">
                <div class="col-6">
                    <small class="m-0">Total pizza</small>
                    <p class="fw-bold fs-6">{{ numberFormat($qty) }} pizza</p>
                    <small class="m-0">Total Pesanan</small>
                    <p class="fw-bold fs-6 mb-0">{{ count($data) }} pesanan</p>
                </div>
                <div class="col-6">
                    <small class="m-0">Omset Penjualan</small>
                    <p class="fw-bold fs-6">IDR {{ numberFormat($gross_profit) }}</p>
                    @php
                        if($net_profit == 0 || $gross_profit == 0){
                            $percentase = 0;
                        }else{
                            $percentase = $net_profit / $gross_profit * 100;
                        }
                    @endphp
                    <small class="m-0">Total Keuntungan ({{ numberFormat($percentase) }}%)</small>
                    <p class="fw-bold fs-6 mb-0">IDR {{ numberFormat($net_profit) }}</p>
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
                    @php
                        $total = 0;
                        foreach ($val as $x) {
                            $total += $x->gross_profit*$x->qty;
                        }
                    @endphp
                    <div class="accordion p-3 mb-3" id="accordion_{{ $key }}" style="border: 1px solid #2125291e;border-radius:15px">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{$key}}">
                                <button class="accordion-button collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="false" aria-controls="collapse_{{$key}}">
                                    <p class="fw-bold m-0 mb-2 me-2">Pesanan ke {{ $index }} {{ $key == null ? '(old data)' : '' }}</p>
                                    <p class="fw-bold m-0 mb-2">IDR {{ numberFormat($total) }}</p>
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
                                                <p class="mb-0 text-capitalize">
                                                    {{ $item->name }}
                                                    {{ $item->is_promo == 1 ? '(Promo)' : '' }}
                                                </p>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="mb-0">{{ numberFormat($item->gross_profit) }} @ {{ $item->qty }} </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0 text-end">IDR {{ numberFormat($item->price*$item->qty) }} </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $total += $item->gross_profit*$item->qty;
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

                                <a href="#" class="text-dark ms-auto text-decoration-none "  data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="note('{{ $note }}')">Catatan</a>
                                @if ($key != null)
                                    <a href="#" class="text-danger text-decoration-none ms-4" onclick="alert_confirm('{{ route('sales.destroy',['id'=>$key]) }}','Hapus pesanan ke {{ $index }}')">Hapus</a>
                                @endif
                            </div>
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
        <div class="modal-content modal-content-bottom vw-100">
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

@section('script')
<script>
    $('#padding-bottom').remove();
    $('#nav-bottom').remove();
</script>
@endsection
