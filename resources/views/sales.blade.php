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
        <div class="row">
            <div class="col-5 pe-0">
                <button
                    type="button"
                    class="btn {{ $isClosed == 1 ? 'bg-white border-0 text-dark' : 'btn-dark text-white' }} w-100 rounded-4 py-3"
                    onclick="closing()"
                    {{ $isClosed == 1 ? 'disabled' : '' }}
                >
                    Tutup Buku
                </button>
            </div>
            <div class="col-7">
                <button
                    type="button"
                    class="btn btn-warning w-100 rounded-4 py-3"
                    data-bs-toggle="modal"
                    data-bs-target="#modal"
                >
                    Tambah
                </button>
            </div>
        </div>
    </div>
</nav>

<div class="px-4 mb-4">
    <p class="fw-bold mb-2">Summary</p>
    <div class="row align-items-stretch">
        <div class="col-9">
            <div class="card h-100 bg-warning text-white rounded-4 border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="bg-white d-flex align-items-center justify-content-center rounded-3" style="width: 50px; aspect-ratio: 1/1">
                                <i class="text-warning" data-feather="credit-card"></i>
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <p class="mb-0 fs-4 fw-bold d-flex align-items-center justify-content-end">
                                IDR {{ number_format($total,0,',','.') }}
                            </p>
                            <p class="mb-0 text-small">
                                Total {{ $qty }} pizza
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card h-100 bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <div class="mb-0 d-block text-center"
                        @if (isOwner())
                            data-bs-toggle="modal" data-bs-target="#filter"
                        @endif
                    >
                        @if (isset($_GET['dateFilter']))
                            <p class="fw-bold mb-0 fs-4 lh-1">
                                {{ customDate($_GET['dateFilter'], 'd') }}
                            </p>
                            <small>
                                {{ customDate($_GET['dateFilter'], 'M') }}
                            </small>
                        @else
                            <p class="fw-bold mb-0 fs-4 lh-1">
                                {{ date('d') }}
                            </p>
                            <small>
                                {{ date('M') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="px-4">
    <div class="row mb-2 px-0">
        <div class="col-6 d-flex align-items-center">
            <p class="fw-bold mb-0">Daftar pesanan</p>
        </div>
        @if (isOwner())
            <div class="col-6 d-flex align-items-center justify-content-end">
                <a class="m-0 text-decoration-none text-dark" href="{{ route('sales.show') }}?dateStartFilter={{ $dateFilter }}&dateEndFilter={{ $dateFilter }}">Selengkapnya</a>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            @if (count($data) == 0)
                {{-- <div class="py-5 mt-5">
                    <center>
                        <img src="{{ asset('app-assets/images/shopping-bag.webp') }}" alt="wallet" class="mb-3" width="30%">
                        <br>
                        <p class="fw-bold fs-4 text-secondary">
                            Belum ada pesanan <br> hari ini
                        </p>
                    </center>
                </div> --}}
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
                        // $date = '';
                        $total = 0;
                        $note = '';
                    @endphp
                    <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                        <div class="card-body">
                            <div class="accordion" id="accordion_{{ $key }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{$key}}">
                                        <button class="accordion-button collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="{{ $index == count($data) ? 'true' : 'false' }}" aria-controls="collapse_{{$key}}">
                                            <p class="fw-bold m-0 mb-2 me-2">{{ date('H:i', strtotime($val[0]->created_at)) }} WIB</p>
                                            <p class="fw-bold m-0 mb-2"> | Orderan-{{ $index }}</p>
                                        </button>
                                    </h2>
                                    <div id="collapse_{{$key}}" class="accordion-collapse collapse {{ $index == count($data) ? 'show' : '' }}" aria-labelledby="heading_{{$key}}" data-bs-parent="#accordion">
                                        <div class="accordion-body p-0 pt-2">
                                            <ul class="ps-3">
                                                @foreach ($val as $item)
                                                    <li>
                                                        <div class="row mb-2">
                                                            <div class="col-12">
                                                                <p class="mb-0 text-capitalize fw-semibold">
                                                                    {{ $item->name }}
                                                                    {{ $item->is_promo == 1 ? '(Promo)' : '' }}
                                                                </p>
                                                                <div class="row text-small">
                                                                    <div class="col-6">
                                                                        <p class="mb-0">{{ numberFormat($item->gross_profit, 0) }} @ {{ $item->qty }} </p>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <p class="mb-0 text-end">IDR {{ numberFormat($item->gross_profit*$item->qty, 0) }} </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $total += $item->gross_profit*$item->qty;
                                                            $date = $item->created_at;
                                                            $note = $item->note;
                                                        @endphp
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-2">
                                        <p class="fw-bold text-start fs-5 mb-0">IDR {{ numberFormat($total, 0) }}</p>

                                        {{-- <a href="#" class="text-dark ms-auto text-decoration-none me-4"  data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="note('{{ $note }}')">Catatan</a> --}}
                                        <a href="#" class="text-small btn btn-warning text-white text-decoration-none rounded-3" onclick="alert_confirm('{{ route('sales.destroy',['id'=>$key]) }}','Hapus pesanan ke {{ $index }}')">
                                            <i data-feather="trash" style="width: 14px"></i>
                                        </a>
                                    </div>
                                </div>
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
<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center border-0">
                <p class="fs-4 m-0 fw-bold">Tambah Pesanan</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark">
                    <i data-feather="x" style="width: 24px"></i>
                </a>
            </div>
            <div class="modal-body pt-3">
                <form action="{{ route('sales.store') }}" method="POST" id="form">
                    @csrf
                    @foreach ($menu as $key => $item)
                        <div class="row align-items-start">
                            <div class="col-7">
                                @if ($item->is_promo == 1)
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light-warning text-small p-1 rounded-3 px-2 me-2" style="width: fit-content !important; height: fit-content !important;">
                                            <i data-feather="percent" class="text-warning" style="width: 12px"></i>
                                        </div>
                                        <p class="fw-bold fs-6 m-0 text-capitalize">
                                            <span class="me-2">
                                                {{ $item->name }}
                                            </span>
                                        </p>
                                    </div>
                                @else
                                    <p class="fw-bold fs-6 m-0 text-capitalize">{{ $item->name }}</p>
                                @endif
                                <div class="d-flex">
                                    @if ($item->is_promo == 1)
                                        <p class="m-0 me-2">IDR {{ numberFormat($item->price_promo,0) }}</p>
                                        <p class="m-0 text-danger">
                                            <strike>
                                                IDR {{ numberFormat($item->price,0) }}
                                            </strike>
                                        </p>
                                    @else
                                        <p class="m-0">IDR {{ numberFormat($item->price,0) }}</p>
                                    @endif
                                </div>
                                <input type="hidden" name="menu_id[]" value="{{ $item->id }}">
                                <input type="hidden" name="qty[]" value="0" id="qty{{ $key }}">
                            </div>
                            <div class="col-5 d-flex align-items-center justify-content-around">
                                <button class="btn btn-dark rounded-3 text-white" onclick="minus('{{ $key }}')" style="width: 40px;height: 40px" type="button" id="min{{ $key }}">
                                    <i data-feather="minus" style="width: 12px"></i>
                                </button>
                                <p class="m-0" id="qty_text{{ $key }}">0</p>
                                <button class="btn btn-warning rounded-3 text-white" onclick="plus('{{ $key }}')" style="width: 40px;height: 40px" type="button" id="min{{ $key }}">
                                    <i data-feather="plus" style="width: 12px"></i>
                                </button>
                            </div>
                        </div>
                        <hr style="opacity: 0.05 !important">
                    @endforeach
                    <button class="d-none" id="btn-submit" type="submit"></button>
                    <input type="text" name="date" value="{{ isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '' }}">
                    <textarea class="d-none" name="note" id="note"></textarea>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" id="btn-form" onclick="$('#note').val($('#note-temp').val());$('#btn-submit').trigger('click');" class="btn btn-warning text-white w-100 rounded-4 py-3">Tambah</button>
            </div>
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
                <form action="{{ route('sales.index') }}" method="get">
                    <input type="date" class="form-control rounded-4" value="{{ $dateFilter }}" name="dateFilter">
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
    });
    document.getElementById("form").addEventListener("submit", function (e) {
        // e.preventDefault();
        const btn = document.getElementById("btn-form");
        btn.disabled = true;
    });
    function minus(key){
        var qty_text = parseInt($('#qty_text'+key).text())
        if(qty_text > 0){
            $('#qty_text'+key).text(qty_text-1)
            $('#qty'+key).val(parseInt($('#qty_text'+key).text()))
        }
    }
    function plus(key){
        var qty_text = parseInt($('#qty_text'+key).text())
        $('#qty_text'+key).text(qty_text+1)
        $('#qty'+key).val(parseInt($('#qty_text'+key).text()))
    }

    function note(note){
        $('#note_text').text(note)
    }

    function closing(){
        Swal.fire({
            title: 'Tutup buku hari ini?',
            icon: 'info',
            text: 'tutup buku adalah migrasi data penjualan ke data transaksi secara keseluruhan',
            showCancelButton: true,
            confirmButtonText: 'Ya, tutup buku',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('sales.migrate') }}?dateFilter={{ $dateFilter }}';
            }
        })
    }
</script>
@endsection
