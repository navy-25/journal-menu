@extends('layouts.master')

@section('css')
<style>

</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
@include('includes.alert')

<nav id="nav-bottom-custom" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="pb-2 pt-3 px-3 w-100">
        <div class="row justify-content-center">
            <div class="col-12">
                <button
                    type="button"
                    class="btn btn-warning w-100 rounded-4 py-3"
                    data-bs-toggle="modal"
                    data-bs-target="#modal"
                    onclick="create()"
                >
                    Tambah
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- NAV BACK --}}
<div id="nav-top" class="px-4 py-3 mb-3 fixed-top d-flex align-items-center justify-content-between bg-body-blur">
    <a href="{{ route('home.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-0">{{ $page }}</h4>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

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
                            <p class="mb-0 text-small">
                                Sisa Kas
                            </p>
                            <p class="mb-0 fs-4 fw-bold d-flex align-items-center justify-content-end">
                                IDR {{ numberFormat($income-$outcome, 0) }}
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
        @php
            $total = $income + $outcome;
            if ($total == 0) {
                $per_in = 0;
                $per_out = 0;
            }else{
                $per_in = ($income / $total) * 100;
                $per_out = ($outcome / $total) * 100;
            }
        @endphp
        <div class="col-12 mt-3">
            <div class="mb-2 d-flex align-items-center justify-content-between">
                <p class="fw-bold mb-0">Rasio Keuangan</p>
            </div>
            <div class="card bg-white text-dark rounded-4 border-0">
                <div class="card-body">
                    <div class="row align-items-start justify-content-between px-1">
                        <div class="col-2">
                            <div
                                class="bg-light-dark d-flex align-items-center justify-content-center rounded-3"
                                style="width: 100%; aspect-ratio: 1/1;cursor: pointer;"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Rp. {{ numberFormat($outcome, 0) }}"
                            >
                                <i class="text-dark" data-feather="arrow-down"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="progress {{ $total == 0 ? "" : "bg-warning" }} mb-1" role="progressbar" aria-label="Warning example" aria-valuenow="{{ $per_out }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-dark" style="width: {{ $per_out }}%"></div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <p class="mb-0 text-dark fw-semibold" style="font-size: .6rem">
                                        {{ numberFormat($per_out, 1) }}%
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0 text-warning fw-semibold" style="font-size: .6rem">
                                        {{ numberFormat($per_in, 1) }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div
                                class="bg-light-warning d-flex align-items-center justify-content-center rounded-3"
                                style="width: 100%; aspect-ratio: 1/1;cursor: pointer;"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Rp. {{ numberFormat($income, 0) }}"
                            >
                                <i class="text-warning" data-feather="arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="px-4">
    <div class="row mb-2 px-0">
        <div class="col-6 d-flex align-items-center">
            <p class="fw-bold mb-0">Daftar transaksi</p>
        </div>
        @if (isOwner())
            <div class="col-6 d-flex align-items-center justify-content-end">
                <a class="m-0 text-decoration-none text-dark" href="{{ route('transaction.show') }}?dateStartFilter={{ $dateFilter }}&dateEndFilter={{ $dateFilter }}">Selengkapnya</a>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            @if (count($data) == 0)
                {{-- <div class="py-5">
                    <center>
                        <img src="{{ asset('app-assets/images/wallet.png') }}" alt="wallet" class="mb-3" width="30%">
                        <br>
                        <p class="fw-bold fs-4 text-secondary">
                            Belum ada transaksi<br>hari ini
                        </p>
                    </center>
                </div> --}}
            @else
                @foreach ($data as $key => $item)
                    <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                        <div class="card-body">
                            <textarea class="d-none" id="data{{ $key }}" cols="30" rows="10">
                                {{ $item }}
                            </textarea>
                            <div class="row mb-2">
                                <div class="col-7"
                                    @if ($item->type == 9)
                                    @elseif ($item->type == 8)
                                    @else
                                        onclick="edit('{{ $key }}','{{ route('transaction.update') }}')"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal"
                                    @endif
                                >
                                    <p class="fw-bold fs-6 m-0 text-capitalize">{{ $item->name }}</p>
                                    <p class="m-0 mb-2">
                                        {{ transactionType($item->type) }}
                                    </p>
                                </div>
                                <div class="col-5 d-flex align-items-start justify-content-end">
                                    <a href="#" class="fw-bold m-0 d-flex align-items-center justify-content-center text-dark text-decoration-none" style="border-radius: 100% !important;">
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
                                <div class="col-6 d-flex align-items-center justify-content-start">
                                    <i data-feather="clock" class="me-2" style="width: 14px"></i>
                                    <small class="me-4">{{ date('H:i', strtotime($item->created_at)) }} WIB</small>
                                </div>
                                <div class="col-6 d-flex align-items-center justify-content-end">
                                    @if ($item->note != '')
                                        <a href="#" class="text-dark text-decoration-none me-3"  data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="note('{{ $item->note }}')">Catatan</a>
                                    @endif
                                    @if ($item->type != 8)
                                        {{-- <a href="#" class="text-danger text-decoration-none ms-auto" onclick="alert_confirm('{{ route('transaction.destroy',['id'=>$item->id]) }}','Hapus {{ $item->name }}')">Hapus</a> --}}

                                        <a href="#" class="text-small btn btn-warning text-white text-decoration-none rounded-3" onclick="alert_confirm('{{ route('transaction.destroy',['id'=>$item->id]) }}','Hapus {{ $item->name }}')">
                                            <i data-feather="trash" style="width: 14px"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Tambah transaksi</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaction.store') }}" method="POST" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Nama pengeluaran</label>
                        <input type="text" class="form-control rounded-4" value="" name="name" id="name" placeholder="ex. ongkos makan" autofocus required>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label opacity-75 text-small">Harga/Total</label>
                                <input type="text" class="form-control rounded-4 money" value="" name="price" id="price" placeholder="ex. 15000" required>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label opacity-75 text-small">Tanggal</label>
                                <input type="date" class="form-control rounded-4" value="{{ $dateFilter }}" name="date" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-label opacity-75 text-small w-100">Masuk/Keluar</label>
                                <select name="status" id="status" class="form-select rounded-4" required>
                                    @foreach (transactionStatus() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label opacity-75 text-small w-100">Untuk keperluan</label>
                                <select name="type" id="type" class="form-select rounded-4" required>
                                    @foreach (transactionType() as $key => $value)
                                        @if ($key == 8)
                                        @elseif ($key == 9)
                                        @else
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Catatan (Optional)</label>
                        <textarea class="form-control rounded-4" name="note" id="note" cols="30" rows="3" placeholder="ex. pakai uangku dulu 200.000"></textarea>
                    </div>
                    <input type="hidden" id="id" name="id">
                    <button class="d-none" id="btn-submit" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" id="btn-form" onclick="$('#btn-submit').trigger('click')" class="btn btn-warning text-white w-100 rounded-4 py-3" id="btn-submit-trigger">Tambah</button>
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
                <form action="{{ route('transaction.index') }}" method="get">
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
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });
    $('.money').mask('000.000.000.000.000', {
        reverse: true
    });
    document.getElementById("form").addEventListener("submit", function (e) {
        // e.preventDefault();
        const btn = document.getElementById("btn-form");
        btn.disabled = true;
    });
    function create(){
        $('#id').val('')
        $('#name').val('')
        $('#type').val(1).trigger('change')
        $('#price').val('')
        $('#status').val('out').trigger('change')
        $('#note').val('')

        $('#form').attr('action','{{ route('transaction.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }
    function edit(key,url){
        var data = JSON.parse($('#data'+key).val())
        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#type').val(data.type).trigger('change')
        $('#price').val(data.price)
        $('#status').val(data.status)
        $('#note').val(data.note)

        $('#form').attr('action',url)
        $('#btn-submit-trigger').text('Simpan')
    }

    function note(note){
        $('#note_text').text(note)
    }
</script>
@endsection
