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
    @include('includes.alert')
    <h6 class="fw-bold mb-4">Daftar {{ $page }}</h6>
</div>
<div class="px-4">
    @foreach ($data as $key => $item)
        <div class="row" onclick="edit('{{ $key }}','{{ route('stock.update') }}')" data-bs-toggle="modal" data-bs-target="#modal">
            <div class="col-3 d-flex justify-content-center align-items-start py-2">
                <div style="width: 50px !important;height: 50px !important" class="bg-warning rounded-circle d-flex justify-content-center align-items-center fw-bold text-capitalize">
                    {{ $item->name[0] }}
                </div>
            </div>
            <div class="col-6 d-flex justify-content-start align-items-center">
                <div>
                    <p class="fw-bold fs-5 m-0 text-capitalize">{{ $item->name }}</p>
                    <p class="m-0 mb-2">{{ $item->qty }} {{ $item->unit }}</p>
                    <textarea  class="d-none" id="data{{ $key }}" cols="30" rows="10">{{ $item }}</textarea>
                </div>
            </div>
            <div class="col-3 d-flex justify-content-center align-items-center fw-bold">
                <p class="fs-1 m-0">
                    {{ $item->qty }}x
                </p>
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
                <form id="form" action="{{ route('stock.store') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Nama bahan</label>
                        <input type="text" class="form-control" placeholder="tulis disini" value="" name="name" id="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Berat/Jumlah</label>
                        <input type="number" class="form-control" placeholder="10/100/400" value="" name="qty" id="qty">
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Satuan (gram/biji/dsb)</label>
                        <input type="text" class="form-control" placeholder="gram/piece/liter" value="" name="unit" id="unit">
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label for="" class="mb-2">Max. pemakaian (Sesuai takaran/pizza)</label>
                        <input type="number" class="form-control" placeholder="5x/10x/40x" value="" name="qty_usage" id="qty_usage">
                    </div> --}}
                    <input type="hidden" name="id" id="id">
                    <button class="d-none" id="btn-submit" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0 px-4" style="flex-wrap: inherit !important">
                <button type="button" id="btn-submit-trigger"
                    {{-- style="width: 70% !important" --}}
                    onclick="$('#btn-submit').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3">
                    Tambah
                </button>
                {{-- <a type="button" id="btn-delete" style="width: 30% !important"
                    class="btn bg-light-danger w-100 rounded-4 py-3">
                    Hapus
                </a> --}}
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

    // function create(){
    //     $('#id').val('')
    //     $('#name').val('')
    //     $('#qty').val('')
    //     $('#unit').val('')
    //     $('#qty_usage').val('')

    //     $('#btn-submit-trigger').css('width','100%')
    //     $('#btn-delete').addClass('d-none')
    //     $('#form').attr('action','{{ route('stock.store') }}')
    //     $('#btn-submit-trigger').text('Tambah')
    // }
    function edit(key,url){
        var data = JSON.parse($('#data'+key).val())

        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#qty').val(data.qty)
        $('#unit').val(data.unit)
        $('#qty_usage').val(data.qty_usage)

        $('#form').attr('action',url)
        $('#btn-submit-trigger').text('Simpan')

        $('#btn-submit-trigger').css('width','70%')
        $('#btn-delete').removeClass('d-none')
        $( "#btn-delete" ).click(function() {
            alert_confirm('{{ route('stock.destroy') }}?id='+data.id, data.name)
        });
    }
</script>
@endsection
