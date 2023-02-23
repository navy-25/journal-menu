@extends('layouts.app')

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
<div class="px-4 py-3 mb-3 bg-white shadow-mini fixed-top d-flex align-items-center">
    <a href="{{ route('settings.index') }}" class="text-decoration-none text-dark">
        <i data-feather="arrow-left" class="me-2 my-0 py-0" style="width: 18px"></i>
    </a>
    <p class="fw-bold m-0 p-0">{{ $page }}</p>
</div>
<div style="height: 80px !important"></div>
{{-- END NAV BACK --}}

<div class="px-4 mb-3">
    <div style="position: fixed;bottom:70px;right:20px;">
        <button type="button" class="btn btn-warning text-dark d-flex align-items-center justify-content-center"
            style="height: 60px;width: 60px;border-radius:100%" onclick="create()">
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

    @if (count($data) == 0)
        <div class="py-5">
            <center>
                <img src="{{ asset('app-assets/images/empty-folder.png') }}" alt="wallet" class="mb-3" width="30%">
                <br>
                <p class="fw-bold fs-4 text-secondary">
                    Belum ada catatan
                </p>
            </center>
        </div>
    @else
        @foreach ($data as $key => $item)
            <div class="row px-2 mb-3">
                <div class="col-12 rounded-5 px-4 py-3" style="border: 1px solid rgba(0, 0, 0, 0.1)" >
                    <div class="d-flex justify-content-start align-items-center" onclick="edit('{{ $key }}','{{ route('note.update') }}')" data-bs-toggle="modal" data-bs-target="#modal">
                        <div>
                            <p class="fw-bold m-0 text-capitalize">{{ $item->title }}</p>
                            <p>{{ $item->description }}</p>
                            <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i data-feather="calendar" class="me-2" style="width: 14px"></i>
                        <small>{{ date('d M Y H:i', strtotime($item->created_at)) }}</small>

                        <a href="#" class="text-danger text-decoration-none ms-auto" onclick="alert_confirm('{{ route('note.destroy',['id'=>$item->id]) }}','Hapus  {{ $item->title }}')">Hapus</a>
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
                        <input type="text" class="form-control" style="height: 50px !important" value="" name="title" id="title" placeholder="tulis judul catatan disini...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="mb-2">Catatan</label>
                        <textarea name="description" class="form-control" id="description" cols="10" rows="4"></textarea>
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
