@extends('layouts.dev')

@section('css')
<style>
    #padding-bottom{
        display: none;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
@endphp
<div class="px-4 mb-3 pt-5">
    <small>Hola!</small>
    <h4 class="fw-bold mb-4">{{ Auth::user()->name }}</h4>
    @include('includes.alert')
</div>

<div class="px-4">
    <div class="card bg-light-warning border-0 rounded-4">
        <div class="card-body p-3">
            <div class="row">
                <div class="col-3 d-flex align-items-center justify-content-center">
                    <div style="border: 1.9px solid #ff9b04;border-radius:50px;width: 50px !important;height: 50px !important" class=" d-flex align-items-center justify-content-center">
                        <i data-feather="users" style="width: 20px !important;height: 20px !important"></i>
                    </div>
                </div>
                <div class="col-9 d-flex align-items-center">
                    <div>
                        <p class="mb-0 fs-7">Total pengguna</p>
                        <p class="mb-0 fs-3 fw-bold">
                            {{ $total_user }} anggota
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script></script>
@endsection
