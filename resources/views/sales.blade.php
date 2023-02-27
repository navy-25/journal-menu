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
<div style="position: fixed;bottom:120px;right:20px;z-index:999">
    <button type="button" class="btn btn-warning text-dark d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%">
        <i data-feather="plus" style="width: 25px" data-bs-toggle="modal" data-bs-target="#modal"></i>
    </button>
</div>
<div style="position: fixed;bottom:200px;right:20px;z-index:999">
    <button type="button" class="btn {{ $isClosed == 1 ? 'bg-dark text-white' : 'btn-danger ' }} d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%" onclick="closing()" {{ $isClosed == 1 ? 'disabled' : '' }}>
        <i data-feather="arrow-right" style="width: 25px"></i>
    </button>
</div>
<div class="px-4 mb-3">
    <h4 class="fw-bold mb-4">{{ $page }}</h4>
    @include('includes.alert')
    <div class="card rounded-4 border-0 mb-4"
        style="box-shadow:5px 4px 30px rgba(53, 53, 53, 0.288);
            background-image:url('app-assets/images/card-bg.jpg');
            background-repeat: no-repeat;
            background-position: right top;
            background-size: cover;
        ">
        <div class="card-body p-4 text-white">
            <p class="fs-5 mb-0">Penjualan</p>
            <p class="mb-3 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filter">
                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                @if (isset($_GET['dateFilter']))
                    {{ customDate($_GET['dateFilter'], 'D, d M Y') }}
                @else
                    {{ date('D, d M Y') }}
                @endif
            </p>
            <h4 class="fw-bold mb-0 text-warning">IDR {{ number_format($total,2,',','.') }}</h4>
            <p class="m-0">{{ $qty }} pizza</p>
        </div>
    </div>
</div>
<div class="px-4">
    <div class="row mb-4 px-0">
        <div class="col-6 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar pesanan</h6>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <a class="m-0 text-decoration-none text-dark" href="{{ route('sales.show') }}">Selengkapnya</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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
                                <button class="accordion-button collapsed p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="{{ $index == count($data) ? 'true' : 'false' }}" aria-controls="collapse_{{$key}}">
                                    <p class="fw-bold m-0 mb-2 me-2">Pesanan ke {{ $index }}</p>
                                    <p class="fw-bold m-0 mb-2" id="total_order_{{$key}}">IDR 0</p>
                                </button>
                            </h2>
                            @php
                                $date = '';
                                $total = 0;
                                $note = '';
                            @endphp
                            <div id="collapse_{{$key}}" class="accordion-collapse collapse {{ $index == count($data) ? 'show' : '' }}" aria-labelledby="heading_{{$key}}" data-bs-parent="#accordion">
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
                                                        <p class="mb-0">{{ numberFormat($item->gross_profit) }} @ {{ $item->qty }} </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0 text-end">IDR {{ numberFormat($item->gross_profit*$item->qty) }} </p>

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
<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-start align-items-center">
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark me-3">
                    <i data-feather="arrow-left" style="width: 18px"></i>
                </a>
                <p class="fs-6 m-0 fw-bold">Tambah Pesanan</p>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    @foreach ($menu as $key => $item)
                        <div class="row">
                            <div class="col-7">
                                <p class="fw-bold fs-6 m-0 text-capitalize">{{ $item->name }}</p>
                                <p class="m-0">IDR {{ numberFormat($item->price) }}</p>
                                <input type="hidden" name="menu_id[]" value="{{ $item->id }}">
                                <input type="hidden" name="qty[]" value="0" id="qty{{ $key }}">
                            </div>
                            <div class="col-5 d-flex align-items-center justify-content-around">
                                <button class="btn btn-dark rounded-4 text-white" onclick="minus('{{ $key }}')" style="width: 40px;height: 40px" type="button" id="min{{ $key }}">
                                    <i data-feather="minus" style="width: 12px"></i>
                                </button>
                                <p class="m-0" id="qty_text{{ $key }}">0</p>
                                <button class="btn btn-dark rounded-4 text-white" onclick="plus('{{ $key }}')" style="width: 40px;height: 40px" type="button" id="min{{ $key }}">
                                    <i data-feather="plus" style="width: 12px"></i>
                                </button>
                            </div>
                        </div>
                        <hr style="opacity: 0.05 !important">
                    @endforeach
                    <button class="d-none" id="btn-submit" type="submit"></button>
                    <textarea class="d-none" name="note" id="note"></textarea>
                </form>
            </div>
            <div class="modal-footer border-0">
                <label for="note" class="me-auto">Catatan khusus</label>
                <textarea class="form-control w-100" id="note-temp" rows="3"></textarea>
                <button type="button" onclick="$('#note').val($('#note-temp').val());$('#btn-submit').trigger('click');" class="btn btn-dark w-100 rounded-4 py-3">Tambah</button>
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
                    <input type="date" class="form-control" style="height: 50px !important" value="{{ $dateFilter }}" name="dateFilter">
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
