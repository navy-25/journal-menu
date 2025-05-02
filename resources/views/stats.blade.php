@extends('layouts.master')

@section('css')
<style>
    /* #padding-bottom{
        display: none;
    } */
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

<nav id="nav-bottom-custom" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="pb-2 pt-3 px-3 w-100">
        <div class="row justify-content-center">
            <div class="col-12">
                <button
                    type="button"
                    class="btn btn-warning w-100 rounded-4 py-3"
                    data-bs-toggle="modal"
                    data-bs-target="#filter"
                >
                    Filter
                </button>
            </div>
        </div>
    </div>
</nav>

<div class="px-4 mb-3">
    <div class="row">
        @if (isOwner())
            <div class="col-12">
                <p class="fw-bold mb-2">Keuntungan</p>
            </div>
            <div class="col-6 mb-3">
                <div class="card bg-warning text-white rounded-4 border-0">
                    <div class="card-body">
                        <div class="bg-white mb-4 d-flex align-items-center justify-content-center rounded-3" style="width: 50px; aspect-ratio: 1/1">
                            <i class="text-warning" data-feather="credit-card"></i>
                        </div>
                        <p class="mb-1 text-small">
                            Total Omset
                        </p>
                        <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                            DR  {{ numberFormat($data['omset'],0) }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="card bg-white text-dark rounded-4 border-0">
                    <div class="card-body">
                        <div
                            class="bg-light-warning mb-4 d-flex align-items-center justify-content-center rounded-3"
                            style="width: 50px; aspect-ratio: 1/1;">
                            <i class="text-warning" data-feather="dollar-sign"></i>
                        </div>
                        <p class="mb-1 text-small">
                            Total Keuntungan
                        </p>
                        <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                            IDR {{ numberFormat($data['laba_kotor'],0) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row gx-2">
        <div class="col-12">
            <p class="fw-bold mb-2">Penjualan</p>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-warning text-white rounded-4 border-0"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Orderan dengan pizza terbanyak"
                style="cursor: pointer;"
            >
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Top Order
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ $topSalesGroup->total_qty }} pcs
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Orderan
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ numberFormat($data['orderan'],0) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Pizza
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ numberFormat($data['qty'],0) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <p class="fw-bold mb-2">Jam Buka</p>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-warning text-white rounded-4 border-0">
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Soon
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ $data['jumlah_hari_belum_tahu'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Buka
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ $data['jumlah_hari_buka'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4 mb-3">
            <div class="card h-100 bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <p class="mb-1 text-small">
                        Tutup
                    </p>
                    <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                        {{ $data['jumlah_hari_tutup'] }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <p class="fw-bold mb-2">
                Grafik
            </p>
        </div>
        <div class="col-8 my-3">
            <div class="form-group">
                <select id="stats" onchange="getChartType()" class="form-select rounded-3 border-0"
                    style="padding:7px 15px !important;font-size:14px !important">
                    <option class="fs-7" value="penjualan">Penjualan</option>
                    <option class="fs-7" value="transaksi">Transaksi</option>
                    <option class="fs-7" value="menu">Menu</option>
                </select>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div id="chart_penjualan">
                <div class="mb-2">
                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                        <div class="card-body">
                            <canvas id="sales_detail" class="w-100 h-100 mb-2"></canvas>
                            <center>
                                <a class="text-decoration-none text-small text-white bg-dark rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#modalIncome">
                                    Semua Data
                                    <i class="ms-2" style="transform: rotate(-225deg); width: 16px" data-feather="arrow-left"></i>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['weekly']) == 0)
                        <center>belum ada data</center>
                    @else
                        <div class="row gx-2">
                            @foreach ($data['weekly'] as $key => $value)
                                @php
                                    $total  = 0;
                                    $profit  = 0;
                                    foreach ($value as $item) {
                                        $gross_profit = $item->qty * $item->gross_profit;
                                        $net_profit = $item->qty * $item->net_profit;
                                        $total += ($item->qty * $item->gross_profit);
                                        $profit += ($gross_profit - $net_profit);
                                    }
                                    if($index == 4){
                                        break;
                                    }
                                @endphp
                                <div class="col-4">
                                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="mb-0" style="font-size:10px !important">{{ customDate($key,'d M') }}</p>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    @if (isOwner())
                                                        <p class="m-0 fw-bold fs-6 text-start text-warning">{{ numberFormat($profit,0) }}</p>
                                                        <p class="m-0 text-start opacity-50" style="font-size:10px !important">
                                                            <s>
                                                                {{ numberFormat($total,0) }}
                                                            </s>
                                                        </p>
                                                    @else
                                                        <p class="m-0 fw-bold fs-6 text-start text-warning">{{ numberFormat($total,0) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $index++
                                @endphp
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div id="chart_transaksi">
                <div class="mb-2">
                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                        <div class="card-body">
                            <canvas id="transactionn_detail" class="w-100 h-100 mb-2"></canvas>
                            <center>
                                <a class="text-decoration-none text-small text-white bg-dark rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#modalOutcome">
                                    Semua Data
                                    <i class="ms-2" style="transform: rotate(-225deg); width: 16px" data-feather="arrow-left"></i>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['weekly-transaction']) == 0)
                        <center>belum ada data</center>
                    @else
                        <div class="row gx-2">
                            @foreach ($data['weekly-transaction'] as $key => $value)
                                @php
                                    $in  = 0;
                                    $out  = 0;
                                    foreach ($value as $item) {
                                        if($item->status == 'in'){
                                            $in += $item->price;
                                        }else{
                                            $out += $item->price;
                                        }
                                    }
                                    $diff = $in - $out;
                                    if($index == 4){
                                        break;
                                    }
                                @endphp
                                <div class="col-4">
                                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="mb-0" style="font-size:10px !important">{{ customDate($key,'d M') }}</p>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <p class="m-0 fw-bold fs-6 text-start text-warning">{{ numberFormat($diff,0) }}</p>
                                                    <p class="m-0 text-start opacity-50" style="font-size:10px !important">
                                                        (Sisa Uang)
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $index++
                                @endphp
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div id="chart_menu">
                <div class="mb-2">
                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                        <div class="card-body">
                            <canvas id="buy_detail" class="w-100 h-100 mb-2"></canvas>
                            <center>
                                <a class="text-decoration-none text-small text-white bg-dark rounded-3 py-2 px-3 d-flex align-items-center justify-content-between" data-bs-toggle="modal" data-bs-target="#modalMenu">
                                    Semua Data
                                    <i class="ms-2" style="transform: rotate(-225deg); width: 16px" data-feather="arrow-left"></i>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['menu']) == 0)
                        <center>belum ada data</center>
                    @else
                        <div class="row gx-2">
                            @foreach ($data['menu'] as $key => $value)
                                @php
                                    if($index == 4){
                                        break;
                                    }
                                @endphp
                                <div class="col-4">
                                    <div class="card h-100 bg-white text-dark rounded-4 border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="mb-0 text-capitalize" style="font-size:10px !important">{{ $value->name }}</p>
                                                </div>
                                                <div class="col-12 mt-1">
                                                    <p class="m-0 fw-bold fs-6 text-start text-warning">{{ numberFormat($value->total_terjual,0) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-8 d-flex justify-content-start align-items-center">
                                        <i data-feather="shopping-bag" class="me-2" style="width: 14px"></i>
                                        {{ $value->name }}
                                    </div>
                                    <div class="col-4 d-flex justify-content-end">
                                        <p class="m-0 fw-bold text-success">{{ numberFormat($value->total_terjual,0) }}</p>
                                    </div>
                                </div>
                                <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important"> --}}
                                @php
                                    $index++
                                @endphp
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <p class="fw-bold mb-2">Berdasarkan shift</p>
        </div>
        <div class="col-12">
            @foreach ($shift as $key => $value)
                <div class="card bg-white text-dark rounded-4 border-0 mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 d-flex justify-content-start align-items-center">
                                <i data-feather="clock" class="me-2" style="width: 14px"></i>
                                <span class="me-2">{{ $value['shift'][0] }} &nbsp; -</span>

                                <i data-feather="clock" class="me-2" style="width: 14px"></i>
                                <span>{{ $value['shift'][1] }}</span>
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <p class="m-0 fw-bold text-dark text-end">
                                    {{ numberFormat($value['total_pembeli'],0) }} pcs
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalIncome" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalIncomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center border-0">
                <p class="fs-4 m-0 fw-bold">Detail penjualan harian</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark">
                    <i data-feather="x" style="width: 24px"></i>
                </a>
            </div>
            <div class="modal-body">
                @php
                    $total_weekly = 0;
                    $total_omset = 0;
                @endphp
                @foreach ($data['weekly'] as $key => $value)
                    @php
                        $total  = 0;
                        $profit  = 0;
                        foreach ($value as $item) {
                            $gross_profit = $item->qty * $item->gross_profit;
                            $net_profit = $item->qty * $item->net_profit;
                            $total += ($item->qty * $item->gross_profit);
                            $profit += ($gross_profit - $net_profit);
                        }
                        $total_weekly += $profit;
                        $total_omset += $total;
                    @endphp
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-start">
                            <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                            {{ formatDay($key) }}, {{ customDate($key,'d M') }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <div class="m-0 text-end">
                                <p class="mb-0" style="font-size: 12px" class="me-2">Omset</p>
                                <p>IDR  {{ numberFormat($total,0) }}</p>
                                @if (isOwner())
                                    <p class="mt-2 mb-0" style="font-size: 12px" class="me-2">Keuntungan</p>
                                    <p class="fw-bold text-success">IDR  {{ numberFormat($profit,0) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
            <div class="modal-footer">
                <div class="w-100 d-flex justify-content-between align-content-start">
                    @if (isOwner())
                        <p class="fw-bold mb-0">Total Keuntungan</p>
                        <p class="fw-bold mb-0 fs-3">IDR {{ numberFormat($total_weekly,0) }}</p>
                    @else
                        <p class="fw-bold mb-0">Total Penjualan</p>
                        <p class="fw-bold mb-0 fs-3">IDR {{ numberFormat($total_omset,0) }}</p>
                    @endif
                </div>
                <div class="alert bg-warning text-white rounded-4 text-center w-100">
                    Belum dikurangi pengeluaran
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalOutcome" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalOutcomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center border-0">
                <p class="fs-4 m-0 fw-bold">Detail transaksi harian</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark">
                    <i data-feather="x" style="width: 24px"></i>
                </a>
            </div>
            <div class="modal-body">
                @php
                    $total_weekly_transaction = 0
                @endphp
                @foreach ($data['weekly-transaction'] as $key => $value)
                    @php
                        $in  = 0;
                        $out  = 0;
                        foreach ($value as $item) {
                            if($item->status == 'in'){
                                $in += $item->price;
                            }else{
                                $out -= $item->price;
                            }
                        }
                        $diff = $in + $out;
                        $total_weekly_transaction += $diff;
                    @endphp
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-start">
                            <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                            {{ formatDay($key) }}, {{ customDate($key,'d M') }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <p class="m-0 text-end">
                                <small class="text-success">(IDR  {{ numberFormat($in,0) }})</small><br>
                                <small class="text-danger">(IDR {{ numberFormat($out,0) }})</small><br><br>
                                <small>Selisih</small><br>
                                <span class="fw-bold {{ $diff < 0 ? 'text-danger' : '' }}">IDR  {{ numberFormat($diff,0) }}</span>
                            </p>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
            <div class="modal-footer">
                <div class="w-100 d-flex justify-content-between align-content-start">
                    <p class="fw-bold mb-0">Sisa Uang Kas</p>
                    <p class="fw-bold mb-0 fs-3">IDR {{ numberFormat($total_weekly_transaction,0) }}</p>
                </div>
                <div class="alert bg-warning text-white rounded-4 text-center w-100">
                    Belum dikurangi modal bahan
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalMenu" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center border-0">
                <p class="fs-4 m-0 fw-bold">Detail penjualan by menu</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark">
                    <i data-feather="x" style="width: 24px"></i>
                </a>
            </div>
            <div class="modal-body">
                @foreach ($data['menu'] as $key => $value)
                    <div class="row">
                        <div class="col-8 d-flex justify-content-start align-items-center">
                            <i data-feather="package" class="me-2" style="width: 15px"></i>
                            {{ $value->name }}
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            <p class="m-0 fw-bold text-success">{{ numberFormat($value->total_terjual,0) }}</p>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
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
                <form action="{{ route('stats.index') }}" method="get">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label opacity-75 text-small">Tanggal awal</label>
                            <input type="date" class="form-control rounded-4"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter">
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label opacity-75 text-small">Tanggal akhir</label>
                            <input type="date" class="form-control rounded-4"
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        // $('#padding-bottom').remove();
        $('#nav-bottom').remove();
        getChartType()
    });
    function getChartType(){
        var type_stats = $('#stats').val()
        if(type_stats == 'penjualan'){
            $('#chart_penjualan').removeClass('d-none')
            $('#chart_transaksi').addClass('d-none')
            $('#chart_menu').addClass('d-none')
        }
        if(type_stats == 'transaksi'){
            $('#chart_transaksi').removeClass('d-none')
            $('#chart_penjualan').addClass('d-none')
            $('#chart_menu').addClass('d-none')
        }
        if(type_stats == 'menu'){
            $('#chart_menu').removeClass('d-none')
            $('#chart_penjualan').addClass('d-none')
            $('#chart_transaksi').addClass('d-none')
        }
    }

    // SALES DETAIL
    const sales_detail = document.getElementById('sales_detail');
    var sales_stats = JSON.parse('{{ $data['weekly'] }}'.replaceAll('&quot;','"'))
    var index = 0
    label_sales_stats = []
    gross_sales_stats = []
    profit_sales_stats = []
    Object.entries(sales_stats).forEach(([key, value]) => {
        if(index < 7){
            var temp_total = 0
            var temp_profit = 0
            label_sales_stats.push(dateFormatDate(key))
            Object.entries(value).forEach(([x, y]) => {
                var gross_profit = y.gross_profit * y.qty
                var net_profit = y.net_profit * y.qty
                temp_total += gross_profit
                temp_profit += (gross_profit - net_profit)
            })
            gross_sales_stats.push(temp_total)
            profit_sales_stats.push(temp_profit)
        }
        index++
    })
    gross_sales_stats.reverse()
    profit_sales_stats.reverse()
    label_sales_stats.reverse()

    var isOwner = parseInt('{{ isOwner() }}')
    if(isOwner == 1){
        var dataset = [
            {
                axis: 'y',
                label: 'Omset Penjualan',
                data: gross_sales_stats,
                fill: true,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgb(255, 159, 64)',
                ],
                borderWidth: 1,
                pointBorderWidth: 2,
                pointRadius: 8,
                pointHitRadius: 4,
            },
            {
                axis: 'y',
                label: 'Keuntungan',
                data: profit_sales_stats,
                fill: true,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.6)',
                ],
                borderColor: [
                    'rgb(255, 159, 64)',
                ],
                borderWidth: 1,
                pointBorderWidth: 2,
                pointRadius: 8,
                pointHitRadius: 4,
            }
        ]
    }else{
        var dataset = [
            {
                axis: 'y',
                label: 'Laba Kotor',
                data: gross_sales_stats,
                fill: true,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)',
                ],
                borderColor: [
                    'rgb(255, 159, 64)',
                ],
                borderWidth: 1,
                pointBorderWidth: 2,
                pointRadius: 8,
                pointHitRadius: 4,
            },
        ]
    }

    const data_sales_detail = {
        labels: label_sales_stats,
        datasets: dataset
    };
    new Chart(sales_detail, {
        responsive: false,
        maintainAspectRatio: true,
        type: 'line',
        data: data_sales_detail,
        options: {
            scales: {
                y: {
                    ticks: {
                        display: false,
                    }
                }
            }
        }
    });
    // SALES DETAIL


    // TRANSACTION DETAIL
    const transaction_detail = document.getElementById('transactionn_detail');
    var transaction_stats = JSON.parse('{{ $data['weekly-transaction'] }}'.replaceAll('&quot;','"'))
    var index = 0
    label_transaction_stats = []
    in_transaction_stats = []
    out_transaction_stats = []
    Object.entries(transaction_stats).forEach(([key, value]) => {
        if(index < 7){
            var temp_in = 0
            var temp_out = 0
            label_transaction_stats.push(dateFormatDate(key))
            Object.entries(value).forEach(([x, y]) => {
                if(y.status  == 'in'){
                    temp_in = parseInt(temp_in) + parseInt(y.price)
                }else{
                    temp_out = parseInt(temp_out) + parseInt(y.price)
                }
            })
            in_transaction_stats.push(temp_in)
            out_transaction_stats.push(temp_out)
        }
        index++
    })
    in_transaction_stats.reverse()
    out_transaction_stats.reverse()
    label_transaction_stats.reverse()
    const data_transaction_detail = {
        labels: label_transaction_stats,
        datasets: [
            {
                axis: 'y',
                label: 'Uang Masuk',
                data: in_transaction_stats,
                fill: true,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                ],
                borderWidth: 1,
                pointBorderWidth: 2,
                pointRadius: 8,
                pointHitRadius: 4,
            },
            {
                axis: 'y',
                label: 'Uang Keluar',
                data: out_transaction_stats,
                fill: true,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                ],
                borderWidth: 1,
                pointBorderWidth: 2,
                pointRadius: 8,
                pointHitRadius: 4,
            }
        ]
    };
    new Chart(transaction_detail, {
        responsive: false,
        maintainAspectRatio: true,
        type: 'line',
        data: data_transaction_detail,
        options: {
            scales: {
                y: {
                    ticks: {
                        display: false,
                    }
                }
            }
        }
    });
    // TRANSACTION DETAIL

    // BUY DETAIL
    const buy_detail = document.getElementById('buy_detail');
    var buy_stats = JSON.parse('{{ $data['menu'] }}'.replaceAll('&quot;','"'))
    var index = 0
    label_buy_stats = []
    data_buy_stats = []
    Object.entries(buy_stats).forEach(([key, value]) => {
        if(index < 7){
            label_buy_stats.push(value.name)
            data_buy_stats.push(value.total_terjual)
        }
        index++
    })
    data_buy_stats
    label_buy_stats
    const data_buy_detail = {
        labels: label_buy_stats,
        datasets: [{
            axis: 'y',
            label: 'Total',
            data: data_buy_stats,
            fill: true,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
            ],
            borderWidth: 1
        }]
    };
    new Chart(buy_detail, {
        responsive: false,
        maintainAspectRatio: true,
        type: 'bar',
        data: data_buy_detail,
        options: {
            indexAxis: 'y',
        }
    });
    // BUY DETAIL
</script>
@endsection
