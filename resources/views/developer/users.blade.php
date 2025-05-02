@extends('layouts.dev')

@section('css')
<style>
    #padding-bottom{
        display: none;
    }
    .table-detail td{
        padding-top:5px;
        padding-bottom:5px;
        vertical-align: text-top;
    }
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
    <div class="row mb-4 px-0">
        <div class="col-12 d-flex align-items-center">
            <h6 class="fw-bold mb-2">Daftar {{ $page }}</h6>
        </div>
    </div>
</div>
<div class="px-4">
    @if (count($data) == 0)
        {{-- <div class="py-5">
            <center>
                <img src="{{ asset('app-assets/images/boy.webp') }}" alt="wallet" class="mb-3" width="30%">
                <br>
                <p class="fw-bold fs-4 text-secondary">
                    Belum ada <br> pengguna
                </p>
            </center>
        </div> --}}
    @else
        @foreach ($data as $key => $value)
            <textarea class="d-none" id="data{{ $key }}">{{ json_encode($value) }}</textarea>
            <div class="row mb-3">
                <div class="col-2 d-flex align-items-center p-1">
                    @php
                        if($value->role == 0){
                            $thumbnail_color = 'bg-dark text-white';
                        }else if($value->role == 1){
                            $thumbnail_color = 'bg-danger text-white';
                        }else{
                            $thumbnail_color = 'bg-warning text-dark';
                        }
                    @endphp
                    <div class="{{ $thumbnail_color }} d-flex justify-content-center align-items-center fw-bold w-100" style="aspect-ratio:1/1 !important; border-radius:100px">
                        {{ $value->name[0] }}
                    </div>
                </div>
                <div class="col-7 d-flex align-items-center justify-content-start">
                    <div>
                        <p class="mb-1" data-bs-toggle="modal" data-bs-target="#modal" onclick="edit('data{{ $key }}')">{{ $value->name }}</p>
                        <div class="d-flex align-items-center">
                            <small class="bg-light-warning fs-7 p-1 rounded-3 px-2 me-2">{{ statusUser($value->status) }}</small>
                            <small class="bg-light-warning fs-7 p-1 rounded-3 px-2">{{ roleUser($value->role) }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-end">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetail" onclick="detail('data{{ $key }}')" class="bg-light-warning rounded-5 p-3 py-2 me-2">
                        <i data-feather="eye" style="width: 10px;"></i>
                    </a>
                    <a href="#" onclick="alert_confirm('{{ route('dev.user.destroy') }}?id={{ $value->id }}','Hapus akun {{ $value->name }}')" class="bg-light-danger rounded-5 p-3 py-2">
                        <i data-feather="trash" style="width: 10px;"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
<!-- Modal -->
<div class="modal fade" id="modal" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Form pengguna</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('dev.user.store') }}" method="POST" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2">Nama merchant</label>
                                <input type="text" class="form-control" value="" name="name" id="name" placeholder="ex. merchant kediri" autofocus>
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2">Nama pemilik</label>
                                <input type="text" class="form-control" value="" name="owner" id="owner" placeholder="ex. yanto">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2">Email</label>
                                <input type="email" class="form-control" value="" name="email" id="email" placeholder="ex. emailmu@gmail.com">
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2">Telepon</label>
                                <input type="number" class="form-control" value="" name="phone" id="phone" placeholder="ex. 0821xxx">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2">
                                    Kata sandi
                                    <span class="d-none" id="password_change_tooltip"> (tidak wajib)</span>
                                </label>
                                <input type="password" class="form-control" value="" name="password" id="password" placeholder="ex. kata sandi">
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Status</label>
                                <select name="status" id="status" class="form-select">
                                    @foreach (statusUser() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Role</label>
                                <select name="role" id="role" class="form-select">
                                    @foreach (roleUser() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="" class="mb-2 w-100">Owner</label>
                                <select name="id_owner" id="id_owner" class="form-select">
                                    <option value="">Pilih salah satu</option>
                                    @foreach ($owner as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="" class="mb-2">Alamat lengkap</label>
                        <textarea class="form-control" name="address" id="address" cols="30" rows="6" placeholder="ex. nama jalan, desa, kecamata, kabupaten"></textarea>
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
            <div class="modal-header d-flex justify-content-start align-items-center border-0">
                <p class="fs-6 m-0 fw-bold">Detail</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body" id="content_detail">
            </div>
            <div class="modal-footer border-0">
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function detail(id){
        var data = JSON.parse($('#'+id).val())
        $('#content_detail').html(`
            <table class="table-detail">
                <tbody>
                    <tr>
                        <td style="width: 100px">Nama</td>
                        <td style="width: 15px">:</td>
                        <td>`+data.name+`</td>
                    </tr>
                    <tr>
                        <td>Pemilik</td>
                        <td style="10px">:</td>
                        <td>`+data.owner+`</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="10px">:</td>
                        <td>`+data.email+`</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td style="10px">:</td>
                        <td>`+data.phone+`</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td style="10px">:</td>
                        <td>`+data.address+`</td>
                    </tr>
                </tbody>
            </table>
        `)
    }

    function edit(id){
        var data = JSON.parse($('#'+id).val())

        $('#name').val(data.name)
        $('#owner').val(data.owner)
        $('#email').val(data.email)
        $('#phone').val(data.phone)
        $('#role').val(data.role).trigger('change')
        $('#status').val(data.status).trigger('change')
        $('#id_owner').val(data.id_owner).trigger('change')
        $('#address').val(data.address)
        $('#id').val(data.id)

        $('#password_change_tooltip').removeClass('d-none')

        $('#form').attr('action','{{ route('dev.user.update') }}')
        $('#btn-submit-trigger').text('Simpan')
    }

    function create(){
        $('#name').val('')
        $('#owner').val('')
        $('#email').val('')
        $('#phone').val('')
        $('#role').val(2).trigger('change')
        $('#id_owner').val('').trigger('change')
        $('#status').val(1).trigger('change')
        $('#address').val('')
        $('#id').val('')

        $('#password_change_tooltip').addClass('d-none')

        $('#form').attr('action','{{ route('dev.user.store') }}')
        $('#btn-submit-trigger').text('Tambah')
    }
</script>
@endsection
