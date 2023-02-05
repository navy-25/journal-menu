@extends('layouts.app')

@section('css')
<style>

</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="px-4 mb-3">
    <div style="position: fixed;bottom:120px;right:20px;">
        <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%">
            <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter"></i>
        </button>
    </div>
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
            <p class="fs-5 mb-0">Pengeluaran</p>
            <p class="mb-3 d-flex align-items-center">
                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                @if (isset($_GET['dateFilter']))
                    {{ customDate($_GET['dateFilter'], 'D, d M Y') }}
                @else
                    {{ date('D, d M Y') }}
                @endif
            </p>
            <h3 class="fw-bold mb-0">IDR {{ numberFormat($total) }}</h3>
        </div>
    </div>
</div>
<div class="px-4">
    <div class="row mb-4 px-0">
        <div class="col-6 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar pegeluaran</h6>
        </div>
        <div class="col-6 d-flex align-items-center justify-content-end">
            <button type="button" class="btn btn-dark py-2 px-3 rounded-4 text-white"
                data-bs-toggle="modal" data-bs-target="#modal" onclick="create()">
                <i data-feather="plus" style="width: 18px"></i>
            </button>
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
                            Belum ada pesanan
                        </p>
                    </center>
                </div>
            @else
                @foreach ($data as $key => $item)
                    <textarea class="d-none" id="data{{ $key }}" cols="30" rows="10">
                        {{ $item }}
                    </textarea>
                    <div class="row">
                        <div class="col-7" onclick="edit('{{ $key }}','{{ route('spend.update') }}')" data-bs-toggle="modal" data-bs-target="#modal" >
                            <p class="fw-bold fs-5 m-0 text-capitalize">{{ $item->name }}</p>
                            <p class="m-0 mb-2">For: {{ spendType($item->type) }} </p>
                            <div class="d-flex align-items-center">
                                <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                                <small>{{ date('d M Y H:i', strtotime($item->created_at)) }}</small>
                            </div>
                        </div>
                        <div class="col-5 d-flex align-items-center justify-content-end">
                            <a href="#" class="fw-bold fs-3 m-0 d-flex align-items-center justify-content-center text-dark bg-warning p-3 py-4 text-decoration-none" style="border-radius: 100% !important;width: 90px !important; height: 90px"
                                onclick="alert_confirm('{{ route('spend.destroy',['id'=>$item->id]) }}','{{ $item->name }}')">
                                {{ numberFormat($item->price / 1000) }}K
                            </a>
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
        <div class="modal-content modal-content-bottom">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Tambah Pengeluaran</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('spend.store') }}" method="POST" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama pengeluaran</label>
                        <input type="text" class="form-control" style="height: 50px !important" value="" name="name" id="name" placeholder="ex. ongkos makan" autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Pilih tipe</label>
                                <select name="type" id="type" class="form-select" style="height: 50px !important">
                                    @foreach (spendType() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2">Harga/Total</label>
                                <input type="text" class="form-control" style="height: 50px !important" value="" name="price" id="price" placeholder="ex. 15000">
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

<div class="modal fade" id="filter" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Filter by tanggal</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('spend.index') }}" method="get">
                    <input type="date" class="form-control" style="height: 50px !important" value="{{ date('Y-m-d') }}" name="dateFilter">
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
    function create(){
        $('#id').val('')
        $('#name').val('')
        $('#type').val(1).trigger('change')
        $('#price').val('')
        $('#note').val('')

        $('#form').attr('action','{{ route('spend.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }
    function edit(key,url){
        var data = JSON.parse($('#data'+key).val())
        console.log(url)
        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#type').val(data.type).trigger('change')
        $('#price').val(data.price)
        $('#note').val(data.note)

        $('#form').attr('action',url)
        $('#btn-submit-trigger').text('Simpan')
    }
</script>
@endsection
