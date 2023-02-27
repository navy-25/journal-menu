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
    <a href="{{ route('transaction.index') }}" class="text-decoration-none text-dark">
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
                <div class="col-6 mb-2">
                    <small class="m-0">Total pemasukan</small> <br>
                    <small class="m-0">Total pengeluaran</small> <br>
                </div>
                <div class="col-6 mb-2">
                    <p class="fw-bold fs-6 mb-0 text-end">IDR {{ numberFormat($income) }}</p>
                    <p class="fw-bold fs-6 mb-0 text-end text-danger">(IDR {{ numberFormat($outcome) }})</p>
                </div>
                <center>
                    <hr class="m-0 my-2 p-0" style="width: 100%;opacity: 10%">
                </center>
                <div class="col-6 mb-2">
                    <small class="m-0">Total keseluruhan</small>
                </div>
                <div class="col-6 mb-2">
                    <p class="fw-bold fs-5 mb-0 text-end">IDR {{ numberFormat($income - $outcome) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h6 class="fw-bold mb-4">Daftar transaksi</h6>
            @if (count($data) == 0)
                <div class="py-5">
                    <center>
                        <img src="{{ asset('app-assets/images/wallet.png') }}" alt="wallet" class="mb-3" width="30%">
                        <br>
                        <p class="fw-bold fs-4 text-secondary">
                            Belum ada transaksi<br>hari ini
                        </p>
                    </center>
                </div>
            @else
                @foreach ($data as $key => $item)
                    <textarea class="d-none" id="data{{ $key }}" cols="30" rows="10">
                        {{ $item }}
                    </textarea>
                    <div class="row mb-2">
                        <div class="col-7" onclick="edit('{{ $key }}','{{ route('transaction.update') }}')" data-bs-toggle="modal" data-bs-target="#modal" >
                            <p class="fw-bold fs-6 m-0 text-capitalize">{{ $item->name }}</p>
                            <p class="m-0 mb-2">{{ transactionType($item->type) }} </p>
                        </div>
                        <div class="col-5 d-flex align-items-top justify-content-end">
                            <a href="#" class="fw-bold m-0 d-flex align-items-center justify-content-center text-dark bg-white text-decoration-none" style="border-radius: 100% !important;">
                                @if ($item->status == 'in')
                                    <i data-feather="arrow-up" class="me-2 text-success fw-bold"></i>
                                @endif
                                @if ($item->status == 'out')
                                    <i data-feather="arrow-down" class="me-2 text-danger fw-bold"></i>
                                @endif
                                <span class="fs-3">
                                    {{ numberFormat($item->price / 1000) }}K
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                            <small class="me-4">{{ date('d M Y', strtotime($item->date)) }}</small>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            @if ($item->note != '')
                                <a href="#" class="text-dark ms-auto text-decoration-none me-4"  data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="note('{{ $item->note }}')">Catatan</a>
                            @endif
                            <a href="#" class="text-danger text-decoration-none ms-auto" onclick="alert_confirm('{{ route('transaction.destroy',['id'=>$item->id]) }}','Hapus {{ $item->name }}')">Hapus</a>
                        </div>
                    </div>
                    <hr style="opacity: 0.1">
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Catatan</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <p id="note_text"></p>
            </div>
            <div class="modal-footer border-0">
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
                <form action="{{ route('transaction.show') }}" method="get">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="" class="mb-2">Tanggal awal</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="" class="mb-2">Tanggal akhir</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateEndFilter'] }}"
                            name="dateEndFilter" required>
                        </div>
                        <div class="col-6 mb-3">
                            @php
                                $type = [
                                    0 => 'Semua',
                                    1 => 'Keperluan Pegawai',
                                    2 => 'Restock Bahan',
                                    3 => 'Operasional',
                                    4 => 'Kebutuhan Alat',
                                    5 => 'Kebutuhan Outlet',
                                    6 => 'Kas Outlet',
                                    7 => 'Lainnya',
                                ];
                            @endphp
                            <label for="" class="mb-2">Kategori</label>
                            <select name="type" class="form-select w-100">
                                @foreach ($type as $key => $item)
                                    <option value="{{ $key }}" {{ activeSelect($key, $typeFilter) }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="" class="mb-2">Urutkan berdasarkan</label>
                            @php
                                $order = [
                                    'date'  => 'Tanggal',
                                    'name'  => 'Nama transaksi',
                                    'price' => 'Nominal',
                                ];
                            @endphp
                            <select name="order" class="form-select w-100">
                                @foreach ($order as $key => $item)
                                    <option value="{{ $key }}" {{ activeSelect($key, $orderFilter) }}>{{ $item }}</option>
                                @endforeach
                            </select>
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
    function note(note){
        $('#note_text').text(note)
    }

    $('#padding-bottom').remove();
    $('#nav-bottom').remove();
</script>
@endsection
