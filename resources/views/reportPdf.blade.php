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
    @php
        $index = 1;
    @endphp
    @foreach ($list_date as $key => $val)
        <div style="width: 100vw !important;height: 100vh !important;position: fixed;z-index: -1;top:25%;left:17%;">
            <img src="http://pizzasuper.viproject.net/app-assets/images/logo-pizza-2.png" alt="" style="width: 450px;opacity: 0.03 !important">
        </div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <img src="http://pizzasuper.viproject.net/app-assets/images/logo-pizza-2.png" alt="" style="width: 80px">
                    </td>
                    <td class="px-4">
                        <p class="my-0 fw-bold fs-4">{{ Auth::user()->name }}</p>
                        <p class="my-0">{{ Auth::user()->address }}</p>
                        <p class="my-0">Telp : {{ Auth::user()->phone }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
        <br>
        <p class="fs-4 fw-bold my-0">{{ ++$key }}. Laporan penjualan {{ formatDay($val) }}, {{ dateFormat($val) }}</p>
        <div style="padding-left: 20px">
            @php
                $qty_total = 0;
                try {
                    $sales[$val];
                    $isSalesShow = 1;
                } catch (\Throwable $th) {
                    $isSalesShow = 0;
                }
            @endphp
            <p>- Kuantitas Penjualan</p>
            <div style="padding-left: 15px">
                @if ($isSalesShow == 1)
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
                @else
                    Tidak ada data ...
                @endif
            </div>
            <br>
            @php
                $total = 0;
                try {
                    $transaction[$val];
                    $isTransShow = 1;
                } catch (\Throwable $th) {
                    $isTransShow = 0;
                }
            @endphp
            <p>- Keuangan Outlet</p>
            <div style="padding-left: 15px">
                @if ($isTransShow == 1)
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
                                        @if($item->status == 'in')
                                            <span>IDR {{ numberFormat($item->price,0) }}</span>
                                        @else
                                            <span class="text-danger">(IDR {{ numberFormat($item->price,0) }})</span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    if($item->status == 'in'){
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
                @else
                    Tidak ada data ...
                @endif
            </div>
        </div>
        <br>
        <br>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 50% !important"></td>
                    <td class="text-center" style="width: 50% !important">
                        <center>
                            .......................,  {{ date('d M Y') }}
                            <br>
                            <p>Mitra</p>
                            <br>
                            ({{ Auth::user()->owner }})
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
        @if ($index <= $key)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>
</html>
