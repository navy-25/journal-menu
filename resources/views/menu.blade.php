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

<div class="px-4 mb-2 mt-4">
    <div class="row px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div>

<nav id="button-create" class="navbar navbar-expand-lg fixed-bottom bg-body-blur" style="height: fit-content !important">
    <div class="pb-2 pt-3 px-3 w-100">
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
<div class="px-4">
    @foreach ($data as $key => $item)
        <div class="card bg-white text-dark rounded-4 border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 d-flex justify-content-start align-items-center">
                        <div class="w-100">
                            <div class="w-100 fw-bold fs-5 mb-1 text-capitalize d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ $item->name }}</p>
                                @if ($item->status == 1)
                                    <i data-feather="eye" width="16px" class="ms-2"></i>
                                @else
                                    <i data-feather="eye-off" width="16px" class="ms-2"></i>
                                @endif
                            </div>
                            <p class="m-0">
                                @if ($item->is_promo == 1)
                                    IDR {{ numberFormat($item->price_promo,0) }} &nbsp;
                                    <span class="text-danger"><s>(IDR {{ numberFormat($item->price,0) }})</s></span>
                                @else
                                    IDR {{ numberFormat($item->price,0) }}
                                @endif
                            </p>
                            <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        HPP: {{ numberFormat($item->hpp,0) }}
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <a href="#" class="text-small btn btn-dark text-white text-decoration-none ms-auto me-2 rounded-3" onclick="edit('{{ $key }}')" data-bs-toggle="modal" data-bs-target="#modal">
                            <i data-feather="edit-2" style="width: 14px"></i>
                        </a>
                        <a href="#" class="text-small btn btn-warning text-white text-decoration-none rounded-3" onclick="alert_confirm('{{ route('menu.destroy',['id'=>$item->id]) }}','Hapus {{ $item->name }}')">
                            <i data-feather="trash" style="width: 14px"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- MDOAL EDIT --}}
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Form {{ $page }}</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('menu.update') }}" method="post" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="form-label opacity-75 text-small">Nama menu</label>
                        <input type="text" class="form-control rounded-4" value="" name="name" id="name" placeholder="ex. pizza green tea">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label opacity-75 text-small">Harga</label>
                                <input type="text" class="form-control rounded-4 money" value="" name="price" id="price" placeholder="ex. 10.000">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label opacity-75 text-small">HPP</label>
                                <input type="text" class="form-control rounded-4 money" value="" name="hpp" id="hpp" placeholder="ex. 7.000">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label opacity-75 text-small">Jadikan Promo</label>
                                <select id="is_promo" onchange="isPromo()" name="is_promo" class="form-select rounded-4">
                                    @foreach (yesNo() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label opacity-75 text-small">Tampilkan Menu</label>
                                <select id="status" name="status" class="form-select rounded-4">
                                    @foreach (yesNo() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3 d-none" id="price_promo_form">
                        <label for="" class="form-label opacity-75 text-small">Harga Promo</label>
                        <input type="text" class="form-control money rounded-4" value="" name="price_promo" id="price_promo" placeholder="ex. 7.000">
                    </div>
                    <input type="hidden" name="id" id="id">
                    <button class="d-none" id="btn-submit-filter" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    id="btn-submit"
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
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script>
    $('.money').mask('000.000.000.000.000', {
        reverse: true
    });
    $(document).ready(function () {
        // $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });

    document.getElementById("form").addEventListener("submit", function (e) {
        // e.preventDefault();
        const btn = document.getElementById("btn-submit");
        btn.disabled = true;
    });

    function isPromo(){
        if($('#is_promo').val() == 1){
            $('#price_promo_form').removeClass('d-none')
        }else{
            $('#price_promo_form').addClass('d-none')
            $('#price_promo').val(0)
        }
    }

    function create(){
        $('#id').val('')
        $('#id').val('')
        $('#name').val('')
        $('#price').val('')
        $('#hpp').val('')
        $('#status').val(1).trigger('change')

        $('#is_promo').val(0).trigger('change')
        $('#price_promo').val('')

        $('#form').attr('action','{{ route('menu.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }

    function edit(key){
        var data = JSON.parse($('#data'+key).val())

        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#price').val(data.price)
        $('#hpp').val(data.hpp)
        $('#status').val(data.status).trigger('change')

        $('#is_promo').val(data.is_promo).trigger('change')
        if(data.is_promo == 1){
            $('#price_promo_form').removeClass('d-none')
            $('#price_promo').val(data.price_promo)
        }else{
            $('#price_promo_form').addClass('d-none')
            $('#price_promo').val(0)
        }
    }
</script>
@endsection
