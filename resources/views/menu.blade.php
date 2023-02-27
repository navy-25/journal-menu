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
{{-- NAV BACK --}}
<div class="px-4 py-4 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('settings.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 100px !important"></div>
{{-- END NAV BACK --}}

<div class="px-4 mb-3">
    <div style="position: fixed;bottom:70px;right:20px;">
        <button type="button" class="btn btn-warning text-dark d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%" disabled>
            <i data-feather="plus" style="width: 25px" data-bs-toggle="modal" data-bs-target="#modal"></i>
        </button>
    </div>
    @include('includes.alert')
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div>
<div class="px-4">
    @foreach ($data as $key => $item)
        <div class="row" onclick="edit('{{ $key }}')" data-bs-toggle="modal" data-bs-target="#edit">
            {{-- <div class="col-3 d-flex justify-content-center align-items-center">
                <img src="{{ asset('app-assets/images/empty.jpg') }}" width="100%" alt="">
            </div> --}}
            <div class="col-12 d-flex justify-content-start align-items-center">
                <div>
                    <p class="fw-bold fs-5 m-0 text-capitalize">{{ $item->name }}</p>
                    <p class="m-0">IDR {{ numberFormat($item->price) }} (HPP: {{ numberFormat($item->hpp) }})</p>
                    <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                </div>
            </div>
        </div>
        <hr style="opacity: 0.1">
    @endforeach
</div>

{{-- MDOAL EDIT --}}
<div class="modal fade" id="edit" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Form edit</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('menu.update') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama menu</label>
                        <input type="text" class="form-control" value="" name="name" id="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Harga</label>
                        <input type="text" class="form-control money" value="" name="price" id="price">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">HPP</label>
                        <input type="text" class="form-control money" value="" name="hpp" id="hpp">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <button class="d-none" id="btn-submit-filter" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" onclick="$('#btn-submit-filter').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3">Simpan</button>
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
    $(document).ready(function () {
        $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });

    function edit(key){
        var data = JSON.parse($('#data'+key).val())

        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#price').val(data.price)
        $('#hpp').val(data.hpp)
    }
</script>
@endsection
