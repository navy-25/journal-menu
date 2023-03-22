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
            <p class="fs-5 mb-0">
                Uang Kas
            </p>
            <p class="mb-2 fs-5 fw-bold d-flex align-items-center text-warning">
                IDR  {{ numberFormat($data['all']) }}
            </p>
            <small class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filter">
                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                {{ dateFormat($dates['dateStartFilter']) }} s/d {{ dateFormat($dates['dateEndFilter']) }}
            </small>
            <p class="fs-6 mb-0 mt-3">Total Pizza </p>
            <p class="m-0 fs-5 fw-bold d-flex align-items-center text-warning">
                <i data-feather="shopping-bag" class="me-2" style="width: 20px;height: 20px"></i>
                {{ numberFormat($data['qty']) }} terjual
            </p>
        </div>
    </div>
</div>
<div class="px-4">
    <div class="card rounded-4 border-0 mb-4 bg-white shadow-mini">
        <div class="card-body p-4">
                <h6 class="fw-bold mb-3">Stock & bahan</h6>
            @php
                $index = 1;
            @endphp
            @foreach ($data['stock'] as $key => $value)
                <div class="row">
                    <div class="col-6 d-flex justify-content-start align-items-center">
                        <i data-feather="package" class="me-2" style="width: 15px"></i>
                        {{ $value->name }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        @php
                            if($value->qty < 100){
                                $textColor = 'text-danger';
                            }else if($value->qty < 150){
                                $textColor = 'text-warning';
                            }else if($value->qty < 200){
                                $textColor = 'text-success';
                            }else{
                                $textColor = 'text-dark';
                            }
                        @endphp
                        <p class="m-0 fw-bold {{ $textColor }}">{{ numberFormat($value->qty,0) }} {{ $value->unit }}</p>
                    </div>
                </div>
                <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important">
            @endforeach
        </div>
    </div>
</div>
<div class="px-4">
    <div class="card rounded-4 border-0 mb-4 bg-white shadow-mini">
        <div class="card-body p-4">
            <div class="form-group">
                <label for="" class="mb-2">Pilih data</label>
                <select id="stats" onchange="getChartType()" class="form-select">
                    <option value="penjualan">Penjualan</option>
                    <option value="transaksi">Transaksi</option>
                    <option value="menu">Menu</option>
                </select>
            </div>
            <hr class="mx-0 my-4" style="opacity: 0.1 !important;">
            <div id="chart_penjualan">
                <div class="row px-0 mb-3">
                    <div class="col-7 d-flex align-items-center">
                        <h6 class="fw-bold">Statistik penjualan</h6>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-end">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalIncome">Semua</a>
                    </div>
                </div>
                <div class="mb-4">
                    <canvas id="sales_detail"></canvas>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['weekly']) == 0)
                        <center>belum ada data</center>
                    @else
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
                                    <p class="m-0 fw-bold text-success">IDR  {{ numberFormat($total) }}</p>
                                </div>
                            </div>
                            <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important">
                            @php
                                $index++
                            @endphp
                        @endforeach
                    @endif
                </div>
            </div>
            <div id="chart_transaksi">
                <div class="row px-0 mb-3">
                    <div class="col-7 d-flex align-items-center">
                        <h6 class="fw-bold">Statistik transaksi</h6>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-end">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalOutcome">Semua</a>
                    </div>
                </div>
                <div class="mb-4">
                    <canvas id="transactionn_detail"></canvas>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['weekly-transaction']) == 0)
                        <center>belum ada data</center>
                    @else
                        @foreach ($data['weekly-transaction'] as $key => $value)
                            @php
                                $total  = 0;
                                foreach ($value as $item) {
                                    if($item->status == 'in'){
                                        $total += $item->price;
                                    }else{
                                        $total -= $item->price;
                                    }
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
                                    <p class="m-0 fw-bold {{ $total > 0 ? 'text-success' : 'text-danger' }}">IDR  {{ numberFormat($total) }}</p>
                                </div>
                            </div>
                            <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important">
                            @php
                                $index++
                            @endphp
                        @endforeach
                    @endif
                </div>
            </div>
            <div id="chart_menu">
                <div class="row px-0 mb-3">
                    <div class="col-7 d-flex align-items-center">
                        <h6 class="fw-bold">Sering dibeli</h6>
                    </div>
                    <div class="col-5 d-flex align-items-center justify-content-end">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalMenu">Semua</a>
                    </div>
                </div>
                <div class="mb-4">
                    <canvas id="buy_detail"></canvas>
                </div>
                <div>
                    @php
                        $index = 1;
                    @endphp
                    @if (count($data['menu']) == 0)
                        <center>belum ada data</center>
                    @else
                        @foreach ($data['menu'] as $key => $value)
                            @php
                                if($index == 4){
                                    break;
                                }
                            @endphp
                            <div class="row">
                                <div class="col-6 d-flex justify-content-start align-items-center">
                                    <i data-feather="shopping-bag" class="me-2" style="width: 15px"></i>
                                    {{ $value->name }}
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <p class="m-0 fw-bold text-success">{{ numberFormat($value->total_terjual) }}</p>
                                </div>
                            </div>
                            <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important">
                            @php
                                $index++
                            @endphp
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="px-4">
    <div class="card rounded-4 border-0 mb-4 bg-white shadow-mini">
        <div class="card-body p-4">
            <div class="row px-0 mb-3">
                <div class="col-12 d-flex align-items-center">
                    <h6 class="fw-bold">Ketegori shift</h6>
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
                <hr class="py-1 mt-2 mb-0" style="opacity: 0.05 !important">
            @endforeach
        </div>
    </div>
</div>
<br>
<br>
<!-- Modal -->
<div class="modal fade" id="modalIncome" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalIncomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark me-3">
                    <i data-feather="arrow-left" style="width: 18px"></i>
                </a>
                <p class="fs-6 m-0 fw-bold">Detail penjualan harian</p>
            </div>
            <div class="modal-body">
                @foreach ($data['weekly'] as $key => $value)
                    @php
                        $total  = 0;
                        foreach ($value as $item) {
                            $total += ($item->qty * $item->gross_profit);
                        }
                    @endphp
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-center">
                            <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                            {{ formatDay($key) }}, {{ customDate($key,'d M') }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <p class="m-0 fw-bold text-success">IDR  {{ numberFormat($total) }}</p>
                        </div>
                    </div>
                    <hr class="py-1 my-2" style="opacity: 0.05 !important">
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalOutcome" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalOutcomeLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark me-3">
                    <i data-feather="arrow-left" style="width: 18px"></i>
                </a>
                <p class="fs-6 m-0 fw-bold">Detail transaksi harian</p>
            </div>
            <div class="modal-body">
                @foreach ($data['weekly-transaction'] as $key => $value)
                    @php
                        $total  = 0;
                        foreach ($value as $item) {
                            if($item->status == 'in'){
                                $total += $item->price;
                            }else{
                                $total -= $item->price;
                            }
                        }
                    @endphp
                    <div class="row">
                        <div class="col-6 d-flex justify-content-start align-items-center">
                            <i data-feather="calendar" class="me-2" style="width: 15px"></i>
                            {{ formatDay($key) }}, {{ customDate($key,'d M') }}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <p class="m-0 fw-bold {{ $total > 0 ? 'text-success' : 'text-danger' }}">IDR  {{ numberFormat($total) }}</p>
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
                            <p class="m-0 fw-bold text-success">{{ numberFormat($value->total_terjual) }}</p>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
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
    data_sales_stats = []
    Object.entries(sales_stats).forEach(([key, value]) => {
        if(index < 7){
            var temp_total = 0
            label_sales_stats.push(dateFormatDate(key))
            Object.entries(value).forEach(([x, y]) => {
                temp_total += y.gross_profit * y.qty
            })
            data_sales_stats.push(temp_total)
        }
        index++
    })
    data_sales_stats.reverse()
    label_sales_stats.reverse()
    const data_sales_detail = {
        labels: label_sales_stats,
        datasets: [{
            axis: 'y',
            label: 'Total',
            data: data_sales_stats,
            fill: true,
            backgroundColor: [
                'rgba(255, 159, 64, 0.2)',
            ],
            borderColor: [
                'rgb(255, 159, 64)',
            ],
            borderWidth: 1
        }]
    };
    new Chart(sales_detail, {
        responsive: true,
        maintainAspectRatio: true,
        type: 'line',
        data: data_sales_detail,
        options: {
            // indexAxis: 'y',scales: {
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
    data_transaction_stats = []
    Object.entries(transaction_stats).forEach(([key, value]) => {
        if(index < 7){
            var temp_total = 0
            label_transaction_stats.push(dateFormatDate(key))
            Object.entries(value).forEach(([x, y]) => {
                temp_total += y.price
            })
            data_transaction_stats.push(temp_total)
        }
        index++
    })
    data_transaction_stats.reverse()
    label_transaction_stats.reverse()
    const data_transaction_detail = {
        labels: label_transaction_stats,
        datasets: [{
            axis: 'y',
            label: 'Total',
            data: data_transaction_stats,
            fill: true,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgb(255, 99, 132)',
            ],
            borderWidth: 1
        }]
    };
    new Chart(transaction_detail, {
        responsive: true,
        maintainAspectRatio: true,
        type: 'line',
        data: data_transaction_detail,
        options: {
            // indexAxis: 'y',scales: {
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
        responsive: true,
        maintainAspectRatio: true,
        type: 'bar',
        data: data_buy_detail,
        options: {
            indexAxis: 'y',
            // scales: {
            //     y: {
            //         ticks: {
            //             display: false,
            //         }
            //     }
            // }
        }
    });
    // BUY DETAIL
</script>
@endsection
