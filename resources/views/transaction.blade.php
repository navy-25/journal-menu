@extends('layouts.master')

@section('css')
<style>

</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div style="position: fixed;bottom:120px;right:20px;z-index:999">
    <button type="button" class="btn btn-warning text-dark d-flex align-items-center justify-content-center"
        style="height: 60px;width: 60px;border-radius:100%" onclick="create()">
        <i data-feather="plus" style="width: 25px" data-bs-toggle="modal" data-bs-target="#modal"></i>
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
        <div class="card-body text-white p-4">
            <div class="row">
                <div class="col-12 text-white mb-3">
                    <p class="fs-5 mb-0">Saldo hari ini</p>
                    <p class="mb-3 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#filter">
                        <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                        @if (isset($_GET['dateFilter']))
                            {{ customDate($_GET['dateFilter'], 'D, d M Y') }}
                        @else
                            {{ date('D, d M Y') }}
                        @endif
                    </p>
                    <p class="fw-bold fs-4 ms-auto mb-1 text-warning">
                        IDR {{ numberFormat($income-$outcome) }}
                    </p>
                </div>
                <div class="col-6">
                    <div class="card text-dark border-0 bg-warning p-2">
                        <div class="d-flex align-items-center">
                            <i data-feather="arrow-up" class="me-auto" style="width: 20px"></i>
                            <p class="fw-bold fs-6 mb-0 ms-auto">{{ numberFormat($income) }}K</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card text-dark border-0 bg-white p-2">
                        <div class="d-flex align-items-center">
                            <i data-feather="arrow-down" class="me-auto" style="width: 20px"></i>
                            <p class="fw-bold fs-6 mb-0 ms-auto">{{ numberFormat($outcome) }}K</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="px-4">
    <div class="row mb-4 px-0">
        <div class="col-6 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar transaksi</h6>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <a class="m-0 text-decoration-none text-dark" href="{{ route('transaction.show') }}">Selengkapnya</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
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

                            {{-- <i data-feather="user-plus" class="me-2" style="width: 14px"></i>
                            <small>{{ date('d M Y H:i', strtotime($item->created_at)) }}</small> --}}
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
                        <label for="" class="mb-2">Nama pengeluaran</label>
                        <input type="text" class="form-control" value="" name="name" id="name" placeholder="ex. ongkos makan" autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2">Harga/Total</label>
                                <input type="text" class="form-control money" value="" name="price" id="price" placeholder="ex. 15000">
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2">Tanggal</label>
                                <input type="date" class="form-control" value="{{ $dateFilter }}" name="date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Masuk/Keluar</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach (transactionStatus() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Untuk keperluan</label>
                                <select name="type" id="type" class="form-select">
                                    @foreach (transactionType() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Catatan (Optional)</label>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="3" placeholder="ex. pakai uangku dulu 200.000"></textarea>
                    </div>
                    <input type="hidden" id="id" name="id">
                    <button class="d-none" id="btn-submit" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" onclick="$('#btn-submit').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3" id="btn-submit-trigger">Tambah</button>
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
                    <input type="date" class="form-control" value="{{ $dateFilter }}" name="dateFilter">
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
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script>
    $('.money').mask('000.000.000.000.000', {
        reverse: true
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
