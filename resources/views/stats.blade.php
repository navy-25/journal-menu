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
    <h4 class="fw-bold mb-4">{{ config('app.name') }}</h4>
    @if ($message = Session::get('success'))
        <div class="alert border-0 alert-warning alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert border-0 alert-dark alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ $message }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
@endsection

@section('script')
<script></script>
@endsection
