<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $page }}</title>
    <style>
        .page_break {
            page-break-before: always !important;
        }
        html,body{
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        .float-start{
            float: left !important;
        }
        .float-end{
            float: right !important;
        }
        .my-0{
            margin-bottom: 0px !important;
            margin-top: 0px !important;
        }
        .fw-bold{
            font-weight: bold;
        }
        .py-4{
            padding-top:20px !important;
            padding-bottom:20px !important;
        }
        .px-4{
            padding-left:20px !important;
            padding-right:20px !important;
        }
        .fs-4{
            font-size: 20px !important
        }
        .p-2{
            padding:10px !important;
        }

        .text-end{
            text-align: right !important;
        }

        .table, .table th, .table td {
            border: 1px solid rgba(0, 0, 0, 0.589) !important;
            border-collapse: collapse !important;
        }
        .text-danger{
            color: rgb(187, 20, 20) !important;
        }
    </style>
</head>
<body>
    @foreach ($list_date as $key => $val)
        <div style="width: 100vw !important;height: 100vh !important;position: fixed;z-index: -1;top:25%;left:17%;">
            <img src="https://pizzasuper.viproject.net/logo-pizza.png" alt="" style="width: 450px;opacity: 0.01 !important">
        </div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <img src="https://pizzasuper.viproject.net/logo-pizza.png" alt="" style="width: 80px">
                    </td>
                    <td class="px-4">
                        <p class="my-0 fw-bold fs-4">Pizza Super Sidoarjo</p>
                        <p class="my-0">Depan Candi Mitra Jaya Auto Car Wash, Jl. Maritim, Balonggabus, <br> Kec. Candi, Kabupaten Sidoarjo, Jawa Timur 61271</p>
                        <p class="my-0">Telp : 0812-1655-2199</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
        <br>
        <p class="fs-4 fw-bold my-0">{{ ++$key }}. Laporan penjualan {{ formatDay($val) }}, {{ dateFormat($val) }} {{ count($list_date) }}</p>
        <div style="padding-left: 20px">
            <p>- Kuantitas Penjualan</p>
            @php
                $qty_total = 0;
                try {
                    $sales[$val];
                } catch (\Throwable $th) {
                    continue;
                }
            @endphp
            <div style="padding-left: 15px">
                <table class="table" style="width: 100%" cellpadding="5">
                    <thead>
                        <tr class="">
                            <td class="fw-bold" style="width: 40%">Nama menu</td>
                            <td class="fw-bold" style="width: 30%">Jumlah</td>
                            <td class="fw-bold" style="width: 30%">Satuan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales[$val] as $key => $item)
                            @php
                                $qty = 0;
                                foreach ($item as $value) {
                                    $qty += $value->qty;
                                }
                            @endphp
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ numberFormat($qty,0) }}</td>
                                <td>pieces</td>
                            </tr>
                            @php
                                $qty_total += $qty;
                            @endphp
                        @endforeach
                        <tr>
                            <td class="fw-bold">Total keseluruhan</td>
                            <td class="fw-bold">{{ numberFormat($qty_total,0) }}</td>
                            <td class="fw-bold">pieces</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <p>- Keuangan Outlet</p>
            @php
                $total = 0;
                try {
                    $transaction[$val];
                } catch (\Throwable $th) {
                    continue;
                }
            @endphp
            <div style="padding-left: 15px">
                <table class="table" style="width: 100%" cellpadding="5">
                    <thead>
                        <tr class="">
                            <td class="fw-bold" style="width: 60%">Nama transaksi</td>
                            <td class="fw-bold text-end" style="width: 40%">Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction[$val] as  $key => $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-end">
                                    @if($item->type == 'in')
                                        <span>IDR {{ numberFormat($item->price,0) }}</span>
                                    @else
                                        <span class="text-danger">(IDR {{ numberFormat($item->price,0) }})</span>
                                    @endif
                                </td>
                            </tr>
                            @php
                                if($item->type == 'in'){
                                    $total += $item->price;
                                }else{
                                    $total -= $item->price;
                                }
                            @endphp
                        @endforeach
                        <tr>
                            <td class="fw-bold">Total keseluruhan</td>
                            <td class="fw-bold text-end">IDR {{ numberFormat($total,0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 50% !important"></td>
                    <td class="text-end" style="width: 50% !important">
                        .......................,  {{ date('d M Y') }}
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        (.........................................)
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="page_break"></div>
    @endforeach
</body>
</html>
