@extends('layouts.master')

@section('css')
<style>
    /* #padding-bottom{
        display: none;
    } */
    .container{
        padding-top: 0px !important;
    }
</style>
@endsection

@section('content')
@php
    date_default_timezone_set('Asia/Jakarta');
    use Carbon\Carbon;

    $start  = Carbon::parse($dates['dateStartFilter']);
    $end    = Carbon::parse($dates['dateEndFilter']);
    $now    = Carbon::now();

    $totalDays          = $start->diffInDays($end) + 1;
    $currentDays        = $start->diffInDays(min($now, $end)) + 1;;
    $progressPercent    = $totalDays > 0 ? round(($currentDays / $totalDays) * 100) : 0;

    // $targetTime = Carbon::createFromTime(18, 0, 0); // jam 18:00
    // $diffInMinutes = $now->diffInMinutes($targetTime, false); // bisa negatif
@endphp
@include('includes.alert')
{{-- <div class="w-100 d-block mb-4">
    <div class="bg-dark p-4 text-center" style="border-radius: 0px 0px 30px 30px">
        <h4 class="fw-bold text-white mt-2">
            @if (isOwner())
                Halo Owner
                {{ Auth::user()->name }}
            @else
                Halo
                {{ Auth::user()->name }}
            @endif
        </h4>
        @if ($diffInMinutes > 0 && $diffInMinutes <= 14)
            <p class="text-white mb-2">📣 Jangan lupa sholat, agar diberikan kelancaran!</p>
        @else
            <p class="text-white mb-2">📣 Selalu jaga tempat kerja agar selalu bersih ya!</p>
        @endif
    </div>
</div> --}}

{{-- NAV BACK --}}
<div id="nav-top" class="px-4 py-3 mb-3 fixed-top d-flex align-items-center justify-content-between bg-body-blur">
    <p class="fw-bold m-0 p-0 fs-4">{{ $page }}</p>
    <button type="button" onclick="alert_confirm('{{ route('login.logout') }}','Yakin keluar?')" class="btn btn-warning text-white outline-0 border-0 shadow-none p-0 rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; aspect-ratio: 1/1">
        <i data-feather="log-out"></i>
    </button>
</div>
<div style="height: 100px !important"></div>
{{-- END NAV BACK --}}

<div class="px-4 mb-3">
    <p class="fw-bold mb-3">Summary</p>
    <div class="row">
        @if (isOwner())
            <div class="col-6 mb-3">
                <div class="card bg-warning text-white rounded-4 border-0">
                    <div class="card-body">
                        <div class="bg-white mb-4 d-flex align-items-center justify-content-center rounded-3" style="width: 50px; aspect-ratio: 1/1">
                            <i class="text-warning" data-feather="credit-card"></i>
                        </div>
                        <p class="mb-1 text-small">
                            Kas Bulan
                            {{ month((int)date('m')) }}
                        </p>
                        <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                            IDR {{ numberFormat($data['month'],0) }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12 mb-3">
                <div class="card bg-warning text-white rounded-4 border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="bg-white d-flex align-items-center justify-content-center rounded-3" style="width: 50px; aspect-ratio: 1/1">
                                    <i class="text-warning" data-feather="credit-card"></i>
                                </div>
                            </div>
                            <div class="col-9 text-end">
                                <p class="mb-1 text-small">
                                    Kas Bulan
                                    {{ month((int)date('m')) }}
                                </p>
                                <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                                    IDR {{ numberFormat($data['month'],0) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (isOwner())
            <div class="col-6 mb-3">
                <div class="card bg-white text-dark rounded-4 border-0">
                    <div class="card-body">
                        <div
                            class="bg-light-warning mb-4 d-flex align-items-center justify-content-center rounded-3"
                            style="width: 50px; aspect-ratio: 1/1;">
                            <i class="text-warning" data-feather="dollar-sign"></i>
                        </div>
                        <p class="mb-1 text-small">Sisa Kas</p>
                        <p class="mb-0 fs-5 fw-bold d-flex align-items-center">
                            IDR  {{ numberFormat($data['sisa']) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 mb-3 mt-3">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <p class="fw-bold mb-0">Counting Days</p>
                <p class="fw-bold mb-0">{{ customDate($currentDays,'d') }} {{ customDate($dates['dateStartFilter'],'M Y') }} </p>
            </div>
            <div
                class="card bg-white text-dark rounded-4 border-0"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Day {{ $currentDays }} of {{ $totalDays }} days ({{ $progressPercent }}%)"
                style="cursor: pointer;"
            >
                <div class="card-body">
                    <div class="row align-items-start justify-content-between px-1">
                        <div class="col-2">
                            <div
                                class="bg-light-warning d-flex align-items-center justify-content-center rounded-3"
                                style="width: 100%; aspect-ratio: 1/1;">
                                <i class="text-warning" data-feather="calendar"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="progress mb-1 mt-2" role="progressbar" aria-label="Warning example" aria-valuenow="3{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: {{ $progressPercent }}%"></div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <p class="mb-0" style="font-size: .6rem">
                                        day 1
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0" style="font-size: .6rem">
                                        day 7
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0" style="font-size: .6rem">
                                        day 14
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0" style="font-size: .6rem">
                                        day 21
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p class="mb-0" style="font-size: .6rem">
                                        day {{ customDate($dates['dateEndFilter'],'d') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="px-4">
    <p class="fw-bold mb-3">Main Menu</p>
    <div class="row">
        @foreach ($menu as $value)
            @if (in_array(Auth::user()->role,$value['access']))
                <div class="col-4 d-flex justify-content-center align-items-center mb-3">
                    <a href="{{ $value['route'] == '' ? '#' : route($value['route']) }}"
                        class="text-decoration-none text-dark text-center px-3 py-3 d-block bg-white border-0 w-100 rounded-5">
                        <img class="mb-3" style="width: 50px;" src="{{ $value['icon'] }}" alt="">
                        <p class="text-small mb-0 fw-semibold">{{ $value['name'] }}</p>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>
<div class="modal fade" id="filter" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterlLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-bottom border-0">
        <div class="modal-content modal-content-bottom vw-100">
            <div class="modal-header border-0 d-flex justify-content-start align-items-center">
                <p class="fs-6 m-0 fw-bold">Filter by tanggal</p>
                <a href="#" data-bs-dismiss="modal" class="text-decoration-none text-dark ms-auto">
                    <i data-feather="x" style="width: 18px"></i>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('stats.index') }}" method="get">
                    <div class="row">
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal awal</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateStartFilter'] }}"
                            name="dateStartFilter">
                        </div>
                        <div class="col-6">
                            <label for="" class="mb-2">Tanggal akhir</label>
                            <input type="date" class="form-control"
                            value="{{ $dates['dateEndFilter'] }}"
                            name="dateEndFilter">
                        </div>
                    </div>
                    <button class="d-none" id="btn-submit-filter" type="submit"></button>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" onclick="$('#btn-submit-filter').trigger('click')" class="btn btn-dark w-100 rounded-4 py-3">Terapkan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
    });
</script>
@endsection
