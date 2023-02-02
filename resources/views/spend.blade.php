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
        <button type="button" class="btn bg-dark text-white d-flex align-items-center justify-content-center" style="height: 60px;width: 60px;border-radius:100%">
            <i data-feather="filter" style="width: 25px" data-bs-toggle="modal" data-bs-target="#filter" disabled></i>
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
                {{ date('D, d M Y') }}
            </p>
            <h3 class="fw-bold mb-0">Rp 0</h3>
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
                data-bs-toggle="modal" data-bs-target="#modal" disabled>
                <i data-feather="plus" style="width: 18px"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="py-5">
                <center>
                    <img src="{{ asset('app-assets/images/wallet.png') }}" alt="wallet" class="mb-3" width="30%">
                    <br>
                    <p class="fw-bold fs-4 text-secondary">
                        Belum ada pesanan
                    </p>
                </center>
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
</script>
@endsection
