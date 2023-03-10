<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Spend;
use App\Models\Stats;
use App\Models\Stock;
use App\Models\Transaction;
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
        if ($request->all() == []) {
            // $dates['dateEndFilter']      = date('Y-m-d');
            // $dates['dateStartFilter']    = date('Y-m-d', strtotime('-6 day', strtotime($dates['dateEndFilter'])));

            $dates['dateEndFilter']      = date('Y-m-t');
            $dates['dateStartFilter']    = date('Y-m-01');
        } else {
            $dates['dateEndFilter']      = $request->dateEndFilter;
            $dates['dateStartFilter']    = $request->dateStartFilter;
        }

        $data['weekly'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->orderBy('sales.date', 'DESC')
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->get()
            ->groupBy('date');
        $data['weekly-transaction'] = Transaction::query()
            ->orderBy('transactions.date', 'DESC')
            ->where('transactions.id_user', Auth::user()->id)
            ->whereBetween('transactions.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->get()
            ->groupBy('date');

        $income = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum(DB::raw('sales.qty * m.price'));

        $trans_outcome = Transaction::where('status', 'out')
            ->where('transactions.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');
        $trans_intcome = Transaction::where('status', 'in')
            ->where('transactions.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');

        $data['all'] = $trans_intcome - $trans_outcome;
        $data['qty'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('sales.qty');
        $data['menu'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', Auth::user()->id)
            ->select('m.name', DB::raw('count(m.id) as total_terjual'))
            ->groupBy('m.name')
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('total_terjual', 'DESC')
            ->get();
        $shift = [
            [
                'shift' => ['00:00', '11:59'],
            ],
            [
                'shift' => ['12:00', '14:59'],
            ],
            [
                'shift' => ['15:00', '18:59'],
            ],
            [
                'shift' => ['19:00', '22:59'],
            ],
            [
                'shift' => ['23:00', '23:59'],
            ],
        ];
        $data['shift_1'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereBetween(DB::raw('TIME(created_at)'), $shift[0]['shift'])
            ->count();
        $data['shift_2'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereBetween(DB::raw('TIME(created_at)'), $shift[1]['shift'])
            ->count();
        $data['shift_3'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereBetween(DB::raw('TIME(created_at)'), $shift[2]['shift'])
            ->count();
        $data['shift_4'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereBetween(DB::raw('TIME(created_at)'), $shift[3]['shift'])
            ->count();
        $data['shift_5'] = Sales::query()
            ->where('sales.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereBetween(DB::raw('TIME(created_at)'), $shift[4]['shift'])
            ->count();

        $shift[0]['total_pembeli'] = $data['shift_1'];
        $shift[1]['total_pembeli'] = $data['shift_2'];
        $shift[2]['total_pembeli'] = $data['shift_3'];
        $shift[3]['total_pembeli'] = $data['shift_4'];
        $shift[4]['total_pembeli'] = $data['shift_5'];

        $data['stock'] = Stock::whereIn('id', [1, 20])->where('id_user', Auth::user()->id)->get();
        return view('stats', compact('data', 'page', 'shift', 'dates'));
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
