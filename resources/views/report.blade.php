@extends('layouts.app')

@section('css')
<style>
    .container{
        padding-top:0px !important;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
{{-- NAV BACK --}}
<div class="px-4 py-4 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('settings.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 100px !important"></div>
{{-- END NAV BACK --}}

<div style="position: fixed;bottom:100px;right:20px;z-index:999">
    <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%">
        <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
    </button>
</div>

{{-- NAV BOTTOM --}}
<nav id="nav-bottom" class="navbar navbar-expand-lg bg-white fixed-bottom px-3" style="height: 100px !important;">
    <button type="button" class="btn btn-warning rounded-4 py-3 px-4 w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#download">Unduh laporan</button>
</nav>
{{-- END NAV BOTTOM --}}

<div class="px-4 mb-3">
    @include('includes.alert')
    <div class="px-2">
        <div class="row p-3 rounded-4 mb-4" style="background: rgba(140, 140, 140, 0.1)">
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
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Kuantitas Penjualan</h6>
        </div>
        <div class="col-12">
            <table id="table-sales" class="table table-bordered table-striped w-100 mx-0">
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
                            <td>{{ $key }}</td>
                            <td>{{ numberFormat($qty,0) }}</td>
                            <td>pieces</td>
                        </tr>
                        @php
                            $qty_total += $qty;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-6">
                    Total keseluruhan
                </div>
                <div class="col-6 fw-bold fs-5 text-end">
                    {{ numberFormat($qty_total,0) }} pieces
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center mb-2">
            <h6 class="fw-bold">Keuangan Outlet</h6>
        </div>
        <div class="col-12">
            <table id="table-transaction" class="table table-bordered table-striped w-100 mx-0">
                <thead>
                    <tr>
                        <td class="fw-bold" style="width: 100px">Tanggal</td>
                        <td class="fw-bold">Nama transaksi</td>
                        <td class="fw-bold">Jumlah</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0
                    @endphp
                    @foreach ($transaction as  $key => $item)
                        <tr>
                            <td>{{ dateFormat($item->date) }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-end">
                                @if($item->type == 'in')
                                    <span>IDR {{ numberFormat($item->price,0) }}</span>
                                @else
                                    <span class="text-danger">(IDR {{ numberFormat($item->price,0) }})</span>
                                @endif
                            </td>
                        </tr>
                        @php
                            if($item->type == 'in'){
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
                    IDR {{ numberFormat($total,0) }}
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
<div class="modal fade" id="download" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="downloadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Format Unduh laporan</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('report.download') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-6 mb-3">
                            <label for="" class="mb-2">Tipe</label>
                            @php
                                $tipe = [
                                    'days'      => 'Harian',
                                    'weeks'     => 'Mingguan',
                                    'months'    => 'Bulanan',
                                    'years'     => 'Tahunan',
                                ];
                            @endphp
                            <select name="type" class="form-select w-100">
                                @foreach ($tipe as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="col-12 mb-3">
                            <label for="" class="mb-2">Fromat</label>
                            @php
                                $format = [
                                    'pdf'      => 'PDF',
                                    'word'     => 'Word',
                                ];
                            @endphp
                            <select name="format" class="form-select w-100">
                                @foreach ($format as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-6 mb-3">
                            <label for="" class="mb-2">Tanggal awal</label>
                            <input type="date" class="form-control" style="height: 50px !important"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="" class="mb-2">Tanggal akhir</label>
                            <input type="date" class="form-control" style="height: 50px !important"
                            value="{{ $dates['dateEndFilter'] }}"
                            name="dateEndFilter">
                        </div>
                    </div>
                    <input type="hidden" name="type" id="type" value="download">
                    <button class="d-none" id="btn-submit-downnload" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <div class="w-100 d-flex">
                    <button type="button" onclick="$('#type').val('view');$('#btn-submit-downnload').trigger('click');$(this).prop('disabled',true)" class="btn btn-light fw-bold w-50 rounded-4 py-3 text-dark me-4">Lihat</button>
                    <button type="button" onclick="$('#type').val('download');$('#btn-submit-downnload').trigger('click');$(this).prop('disabled',true)" class="btn btn-warning fw-bold w-50 rounded-4 py-3">Unduh</button>
                </div>
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
        $('#table-sales').DataTable({
            paging: false,
            ordering: true,
            order: [[1, 'DESC']],
            searching: false,
            info: false,
        });
        $('#table-transaction').DataTable({
            paging: false,
            ordering: true,
            order: [[0, 'DESC']],
            searching: false,
            info: false,
        });
    } );
</script>
@endsection
