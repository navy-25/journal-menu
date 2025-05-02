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

<div class="px-4 mb-3 mt-4">
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div>

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

<div class="px-4">
    @if (count($data) == 0)
        {{-- <div class="py-5">
            <center>
                <img src="{{ asset('app-assets/images/empty-folder.png') }}" alt="wallet" class="mb-3" width="30%">
                <br>
                <p class="fw-bold fs-4 text-secondary">
                    Belum ada catatan
                </p>
            </center>
        </div> --}}
    @else
        @foreach ($data as $key => $item)
            <div class="card bg-white text-dark rounded-4 border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 rounded-5">
                            <div class="d-flex justify-content-start align-items-center" onclick="edit('{{ $key }}','{{ route('note.update') }}')" data-bs-toggle="modal" data-bs-target="#modal">
                                <div>
                                    <p class="fw-bold mb-2 text-capitalize">{{ $item->title }}</p>
                                    <p>{{ $item->description }}</p>
                                    <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                                    <small>{{ date('d M Y H:i', strtotime($item->created_at)) }}</small>
                                </div>

                                <a href="#" class="text-small btn btn-warning text-white text-decoration-none rounded-3" onclick="alert_confirm('{{ route('note.destroy',['id'=>$item->id]) }}','Hapus {{ $item->title }}')">
                                    <i data-feather="trash" style="width: 14px"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

{{-- MDOAL MODAL --}}
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Tambah catatan</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('note.store') }}" method="post" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="title" class="mb-2">Judul</label>
                        <input type="text" class="form-control rounded-4" value="" name="title" id="title" placeholder="tulis judul catatan disini...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="mb-2">Catatan</label>
                        <textarea name="description" class="form-control rounded-4" style="height: 200px !important" id="description" cols="10" rows="4"></textarea>
                    </div>
                    <input type="hidden" name="id" id="id">
                    <button class="d-none" id="btn-submit" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" id="btn-submit-trigger" onclick="$('#btn-submit').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3">Tambah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#padding-bottom').remove();
        $('#nav-bottom').remove();
    });

    function create(){
        $('#id').val('')
        $('#title').val('')
        $('#description').val('')

        $('#form').attr('action','{{ route('note.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }
    function edit(key,url){
        var data = JSON.parse($('#data'+key).val())
        $('#id').val(data.id)
        $('#title').val(data.title)
        $('#description').val(data.description)

        $('#form').attr('action',url)
        $('#btn-submit-trigger').text('Simpan')
    }
</script>
@endsection
