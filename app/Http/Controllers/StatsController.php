<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Stats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Statistik';
        $data['weekly'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->orderBy('sales.date', 'DESC')
            ->get()
            ->groupBy('date');
        $data['all'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->sum(DB::raw('sales.qty * m.price'));
        $data['qty'] = Sales::query()
            ->sum('sales.qty');
        $data['menu'] = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select('m.name', DB::raw('count(m.id) as total_terjual'))
            ->groupBy('m.id')
            ->orderBy('total_terjual', 'DESC')
            ->get();

        $shift = [
            [
                'shift' => ['12:00', '14:59'],
            ],
            [
                'shift' => ['15:00', '18:59'],
            ],
            [
                'shift' => ['19:00', '22:59'],
            ],
        ];
        $data['shift_1'] = Sales::query()->whereBetween(DB::raw('TIME(created_at)'), $shift[0]['shift'])->count();
        $data['shift_2'] = Sales::query()->whereBetween(DB::raw('TIME(created_at)'), $shift[1]['shift'])->count();
        $data['shift_3'] = Sales::query()->whereBetween(DB::raw('TIME(created_at)'), $shift[2]['shift'])->count();

        $shift[0]['total_pembeli'] = $data['shift_1'];
        $shift[1]['total_pembeli'] = $data['shift_2'];
        $shift[2]['total_pembeli'] = $data['shift_3'];
        return view('stats', compact('data', 'page', 'shift'));
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
