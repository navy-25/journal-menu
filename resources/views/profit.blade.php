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
{{-- NAV BACK --}}
<div class="px-4 py-4 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('home.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 100px !important"></div>
{{-- END NAV BACK --}}

<div style="position: fixed;bottom:50px;right:20px;z-index:999">
    <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%">
        <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
    </button>
</div>

<div class="px-4 mb-3">
    @include('includes.alert')
    <div class="px-2">
        <div class="row p-3 rounded-4 mb-4" style="background: rgba(140, 140, 140, 0.1)">
            <div class="col-6">
                <small class="m-0 d-flex align-items-center">
                    <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                    Tgl. Transaksi
                </small>
            </div>
            <div class="col-6 text-end">
                <p class="fw-bold fs-6 mb-0">{{ dateFormat($dates['dateFilter']) }}</p>
            </div>
        </div>
    </div>
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Rangkuman</h6>
        </div>
        <div class="col-12">
            <table class="table table-bordered table-striped w-100 mx-0">
                <thead>
                    <tr>
                        <td style="width: 30%">#</td>
                        <td style="width: 35%">Value</td>
                        <td style="width: 35%">Status</td>
                    </tr>
                </thead>
                <tbody>
                    {{-- <tr>
                        <td>Selisih</td>
                        <td class="text-end">IDR {{ numberFormat(($temp_diff - $total) / 1000,0) }}</td>
                        <td>{{ $diff }}</td>
                    </tr> --}}
                    <tr>
                        <td>Sisa Kas</td>
                        <td id="finance-value" class="text-end"></td>
                        <td id="finance-status">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Omset</td>
                        <td id="omset-value" class="text-end"></td>
                        <td id="omset-status" class="text-danger">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Laba Kotor</td>
                        <td colspan="2" id="laba-kotor-value" class="text-center text-success fw-bold">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="px-4 mb-3">
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Detail Kas</h6>
        </div>
        <div class="col-12">
            <table id="table-cash" class="table table-bordered table-striped w-100 mx-0">
                <thead>
                    <tr>
                        <td class="fw-bold">Deskripsi</td>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold">Saldo</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $temp_balance = 0;
                    @endphp
                    @foreach ($transaction as $key => $value)
                        @php
                            $balance = $value->price;
                            if ($value->type == 9) {
                                $temp_balance = $balance;
                            }else{
                                if ($value->status == 'in') {
                                    $temp_balance += $balance;
                                }
                                if ($value->status == 'out') {
                                    $temp_balance -= $balance;
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td class="{{ $value->status == 'in' ? 'text-success' : '' }}">{{ numberFormat($balance / 1000,1) }}K </td>

                            @if ($temp_balance >= 0)
                                <td>{{ numberFormat($temp_balance / 1000,1) }}K </td>
                            @else
                                <td class="text-danger">({{ numberFormat($temp_balance / 1000,1) }}K)</td>
                            @endif
                        </tr>
                    @endforeach
                    <script>
                        setTimeout(() => {
                            var funds = parseInt('{{ $temp_balance }}')
                            var nominal = '{{ numberFormat($temp_balance,0) }}'.replaceAll('-','')
                            if(funds == 0 ){
                                $('#finance-status').text('EMPTY')
                                $('#finance-value').text('IDR '+nominal)
                            }else if(funds > 0 ){
                                $('#finance-status').text('PROFIT')
                                $('#finance-value').text('IDR '+nominal)
                                $('#finance-status').addClass('text-success')
                                $('#finance-value').addClass('text-success')
                            }else{
                                $('#finance-status').text('MINUS')
                                $('#finance-value').text('IDR '+nominal)
                                $('#finance-status').addClass('text-danger')
                                $('#finance-value').addClass('text-danger')
                            }
                        }, 1000);
                    </script>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="px-4 mb-3">
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Perhitungan Penjualan</h6>
        </div>
        <div class="col-12">
            <table id="table-profit" class="table table-bordered table-striped w-100 mx-0">
                <thead>
                    <tr>
                        <td class="fw-bold">ID</td>
                        <td class="fw-bold">Total</td>
                        <td class="fw-bold">HPP</td>
                        <td class="fw-bold">Laba</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $total_hpp = 0;
                        $total_clean = 0;
                    @endphp
                    @foreach ($sales as $key => $value)
                        <tr>
                            @php
                                $gross_profit = $value->gross_profit * $value->qty;
                                $net_profit = $value->net_profit * $value->qty;

                                $name = explode(' ',$value->name);
                                $temp_total = ($gross_profit) / 1000;
                                $temp_total_hpp = $net_profit / 1000;
                                $temp_total_clean = ($gross_profit - $net_profit) / 1000;
                                $temp_perc = (($gross_profit - $net_profit) / $gross_profit) * 100;
                            @endphp
                            <td class="text-uppercase">
                                @foreach ($name as $text){{ $text[0] }}@endforeach
                            </td>
                            <td>{{ numberFormat($temp_total,1) }}K</td>
                            <td>{{ numberFormat($temp_total_hpp,1) }}K</td>
                            <td>{{ numberFormat($temp_total_clean,1) }}K</td>
                        </tr>
                        @php
                            $total += $gross_profit;
                            $total_hpp += $net_profit;
                            $total_clean += $gross_profit - $net_profit;
                        @endphp
                    @endforeach
                    <tr>
                        <td class="fw-bold">#</td>
                        <td class="fw-bold">{{ numberFormat($total / 1000,1) }}K</td>
                        <td class="fw-bold">{{ numberFormat($total_hpp / 1000,1) }}K</td>
                        <td class="fw-bold">{{ numberFormat($total_clean / 1000,1) }}K</td>
                    </tr>
                </tbody>
            </table>
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
                <form action="{{ route('profit.index') }}" method="get">
                    <div class="row">
                        <div class="col-12">
                            <input type="date" class="form-control"
                            value="{{ $dates['dateFilter'] }}"
                            name="dateFilter">
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
    $(document).ready(function () {
        $('#padding-bottom').remove();
        $('#nav-bottom').remove();
        $('#table-profit').DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
        });
        $('#table-cash').DataTable({
            paging: false,
            ordering: false,
            searching: false,
            info: false,
        });
        $('#laba-kotor-value').text('IDR {{ numberFormat($total_clean,0) }}')
        $('#omset-value').text('IDR {{ numberFormat($total,0) }}')
        $('#omset-status').text('IDR {{ numberFormat($total_hpp,0) }} (HPP)')
    });
</script>
@endsection
