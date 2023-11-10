<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Transaction;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');
class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Laba Harian';
        if ($request->all() == []) {
            $dates['dateEndFilter']      = date('Y-m-d');
            $dates['dateStartFilter']    = date('Y-m-d');
        } else {
            $dates['dateEndFilter']      = $request->dateEndFilter;
            $dates['dateStartFilter']    = $request->dateStartFilter;
        }
        $sales = Sales::query()
            ->where('sales.id_user', getUserID())
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->get();

        $temp_hpp = Sales::query()
            ->where('sales.id_user', getUserID())
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->get();

        $hpp = 0;
        $total = 0;
        $profit = 0;
        foreach ($temp_hpp as $key => $value) {
            $net_profit = $value->qty * $value->net_profit;
            $gross_profit = $value->qty * $value->gross_profit;

            $hpp += $net_profit;
            $total += $gross_profit;
            $profit += ($gross_profit - $net_profit);
        }
        $temp_diff = $hpp + $profit;
        $diff = '';
        if($temp_diff == $total){
            $diff = 'BALANCED';
        }else{
            $diff = 'UNBALANCED';
        }

        $transaction = Transaction::query()
                ->where('transactions.id_user', getUserID())
                ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
                ->orderBy('status','ASC')
                ->get();
        return view('profit', compact('page','sales','transaction','hpp','diff','temp_diff','total', 'dates'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
