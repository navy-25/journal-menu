<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesGroup;
use App\Models\Stats;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');
class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Statistik';

        $userID = getUserID();
        $dateStart = $request->dateStartFilter ?? date('Y-m-01');
        $dateEnd = $request->dateEndFilter ?? date('Y-m-t');

        $dates = [
            'dateStartFilter' => $dateStart,
            'dateEndFilter' => $dateEnd,
        ];

        // Ambil semua sales sekaligus
        $salesAll = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', $userID)
            ->whereBetween('sales.date', [$dateStart, $dateEnd])
            ->get();

        $data['weekly'] = $salesAll->groupBy('date');

        // Cari tanggal penjualan terbanyak
        $maxDate = null;
        $maxTotal = 0;
        foreach ($data['weekly'] as $date => $sales) {
            $totalSales = $sales->sum('qty');
            if ($totalSales > $maxTotal) {
                $maxTotal = $totalSales;
                $maxDate = $date;
            }
        }
        $data['top_sales_date'] = $maxDate;

        // Weekly Transaction
        $data['weekly-transaction'] = Transaction::query()
            ->orderBy('transactions.date', 'DESC')
            ->where('transactions.id_user', $userID)
            ->whereBetween('transactions.date', [$dateStart, $dateEnd])
            ->get()
            ->groupBy('date');

        // Jumlah orderan
        $data['orderan'] = SalesGroup::where('id_user', $userID)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->count();

        // Omset
        $data['omset'] = Transaction::where('status', 'in')
            ->where('id_user', $userID)
            ->where('type', 9)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->sum('price');

        // Laba kotor
        $data['laba_kotor'] = Sales::where('id_user', $userID)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->sum(DB::raw('(qty * gross_profit) - (qty * net_profit)'));

        // Total QTY
        $data['qty'] = $salesAll->sum('qty');

        // Menu Terlaris
        $data['menu'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', $userID)
            ->whereBetween('sales.date', [$dateStart, $dateEnd])
            ->select('m.name', DB::raw('count(m.id) as total_terjual'))
            ->groupBy('m.name')
            ->orderByDesc('total_terjual')
            ->get();

        // Shift Analysis
        $shiftDefinitions = [
            ['00:00', '11:59'],
            ['12:00', '14:59'],
            ['15:00', '18:59'],
            ['19:00', '22:59'],
            ['23:00', '23:59'],
        ];

        foreach ($shiftDefinitions as $i => $timeRange) {
            $shiftQty = Sales::query()
                ->where('id_user', $userID)
                ->whereBetween('date', [$dateStart, $dateEnd])
                ->whereBetween(DB::raw('TIME(created_at)'), $timeRange)
                ->sum('qty');

            $data["shift_" . ($i + 1)] = $shiftQty;

            $shift[$i] = [
                'shift' => $timeRange,
                'total_pembeli' => $shiftQty,
            ];
        }

        // Stock
        $data['stock'] = Stock::where('id_user', $userID)->get();

        // Top Sales Group
        $topSalesGroup = Sales::query()
            ->where('sales.id_user', $userID)
            ->whereBetween('sales.date', [$dateStart, $dateEnd])
            ->select('sales.sales_group_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('sales.sales_group_id')
            ->orderByDesc('total_qty')
            ->first();

        // Hitung jumlah hari buka dan tutup
        // 1. Buat daftar semua tanggal dalam rentang filter
        $allDates = collect();
        $start = Carbon::parse($dateStart);
        $end = Carbon::parse($dateEnd);
        $end = Carbon::parse($dateEnd);
        while ($start->lte($end)) {
            $allDates->push($start->copy());
            $start->addDay();
        }
        $activeDates = SalesGroup::where('id_user', $userID)
            ->whereBetween('date', [$dateStart, $dateEnd])
            ->select('date')
            ->distinct()
            ->pluck('date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));

        $jumlahBuka = 0;
        $jumlahTutup = 0;
        $jumlahBelumTahu = 0;

        foreach ($allDates as $date) {
            $dateStr = $date->format('Y-m-d');
            if ($activeDates->contains($dateStr)) {
                $jumlahBuka++;
            } elseif ($date->isFuture()) {
                $jumlahBelumTahu++;
            } else {
                $jumlahTutup++;
            }
        }

        $data['jumlah_hari_buka'] = $jumlahBuka;
        $data['jumlah_hari_tutup'] = $jumlahTutup;
        $data['jumlah_hari_belum_tahu'] = $jumlahBelumTahu;
        return view('stats', compact('data', 'page', 'shift', 'dates','topSalesGroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stats  $stats
     * @return \Illuminate\Http\Response
     */
    public function show(Stats $stats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stats  $stats
     * @return \Illuminate\Http\Response
     */
    public function edit(Stats $stats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stats  $stats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stats $stats)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stats  $stats
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stats $stats)
    {
        //
    }
}
