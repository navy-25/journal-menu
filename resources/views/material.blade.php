@extends('layouts.master')

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

@include('includes.alert')

{{-- NAV BACK --}}
<div id="nav-top" class="px-4 py-3 mb-3 fixed-top d-flex align-items-center justify-content-between bg-body-blur">
    <a href="{{ route('settings.index') }}" class="btn btn-light bg-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="chevron-left"></i>
    </a>
    <h4 class="fw-bold mb-0">{{ $page }}</h4>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<nav id="button-create" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="py-2 px-3 w-100">
        <div class="d-flex justify-content-end w-100 align-items-center rounded-4 p-2">
            <button
                type="button"
                class="btn btn-warning text-white rounded-4 py-3 w-100"
                onclick="create()"
                data-bs-toggle="modal"
                data-bs-target="#modal"
            >
                <span class="ms-2 fw-bold">Tambah</span>
            </button>
        </div>
    </div>
</nav>

<div class="px-4 mb-3">
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div>

<div class="px-4">
    @foreach ($data as $key => $item)
        <div class="row mb-3">
            <div class="col-2 d-flex justify-content-center align-items-center">
                <div class="w-100 h-100 bg-warning rounded-3 d-flex align-items-center justify-content-center text-uppercase fw-bold">
                    {{ $item->name[0] }}{{ $item->name[1] }}
                </div>
            </div>
            <div class="col-10 d-flex justify-content-start align-items-center ps-1">
                <div class="w-100">
                    <div class="row">
                        <div class="col-6">
                            <p class="fw-bold fs-5 m-0 text-capitalize">{{ $item->name }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="m-0 text-capitalize">IDR {{ numberFormat($item->price) }}</p>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8 d-flex align-items-center">
                            <i data-feather="map" class="me-2" style="width: 14px"></i>
                            <small class="me-4">{{ $item->shop }}</small>
                        </div>
                        <div class="col-4 d-flex align-items-center justify-content-end">
                            <a href="#" class="text-dark text-decoration-none ms-auto me-4" onclick="edit('{{ $key }}','{{ route('material.update',['id'=>$item->id]) }}')" data-bs-toggle="modal" data-bs-target="#modal">Edit</a>
                            <a href="#" class="text-danger text-decoration-none" onclick="alert_confirm('{{ route('material.destroy',['id'=>$item->id]) }}','Hapus {{ $item->name }}')">Hapus</a>
                        </div>
                        <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr style="opacity: 0.1">
    @endforeach
</div>

{{-- MDOAL EDIT --}}
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center p-4">
                <p class="fs-6 m-0 fw-bold">Tambahkan bahan baru</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body px-4">
                <form id="form" action="{{ route('material.store') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Nama bahan</label>
                        <input type="text" class="form-control rounded-4" placeholder="tulis disini" value="" name="name" id="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Harga</label>
                        <input type="text" class="form-control rounded-4 money" value="" name="price" id="price" placeholder="ex. 10.000">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Merek</label>
                        <input type="text" class="form-control rounded-4" placeholder="tulis disini" value="" name="merk" id="merk">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Tempat Beli</label>
                        <input type="text" class="form-control rounded-4" placeholder="tulis disini" value="" name="shop" id="shop">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <button class="d-none" id="btn-submit" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    class="btn btn-warning text-white rounded-4 py-3 w-100"
                    onclick="$('#btn-submit-filter').trigger('click')"
                >
                    <span class="ms-2 fw-bold">Simpan</span>
                </button>
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

    function create(){
        $('#id').val('')
        $('#name').val('')
        $('#merk').val('')
        $('#shop').val('')
        $('#price').val('')

        $('#form').attr('action','{{ route('material.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }

    function edit(key,url){
        var data = JSON.parse($('#data'+key).val())

        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#merk').val(data.merk)
        $('#shop').val(data.shop)
        $('#price').val(data.price)

        $('#form').attr('action',url)
        $('#btn-submit-trigger').text('Simpan')
    }
</script>
@endsection
