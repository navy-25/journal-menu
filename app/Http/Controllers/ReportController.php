<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Sales;
use App\Models\Transaction;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page   = 'Laporan';

        if ($request->all() == []) {
            $dates['dateEndFilter']      = date('Y-m-d');
            $dates['dateStartFilter']    = date('Y-m-d', strtotime('-1 weeks', strtotime($dates['dateEndFilter'])));
        } else {
            $dates['dateEndFilter']      = $request->dateEndFilter;
            $dates['dateStartFilter']    = $request->dateStartFilter;
        }

        $sales = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->leftJoin('sales_groups as g', 'g.id', 'sales.sales_group_id')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'g.note',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy('name');

        $transaction = Transaction::query()
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('date', 'DESC')
            ->get();

        return view('report', compact('page', 'sales', 'dates', 'transaction'));
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
    public function download(Request $request)
    {
        $page                       = 'Laporan outlet ' . dateFormat($request->dateStartFilter) . ' - ' . dateFormat($request->dateEndFilter);
        $dates['dateEndFilter']     = $request->dateEndFilter;
        $dates['dateStartFilter']   = $request->dateStartFilter;
        $sales = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->leftJoin('sales_groups as g', 'g.id', 'sales.sales_group_id')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'g.note',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy(['date', 'name']);
        $transaction = Transaction::query()
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('date', 'DESC')
            ->get()
            ->groupBy('date');

        $list_date = [];
        foreach ($sales as $key => $value) {
            $list_date[]  = $key;
        }
        foreach ($transaction as $key => $value) {
            $list_date[]  = $key;
        }
        $list_date = array_unique($list_date);
        sort($list_date);
        $pdf = PDF::loadView('reportPdf', compact('page', 'sales', 'transaction', 'dates', 'list_date'));
        $pdf->setPaper('a4', 'potrait');

        if ($request->type == 'view') {
            // open to view PDF browser
            return $pdf->stream();
        } else {
            // download
            return $pdf->download('Laporan outlet ' . dateFormat($request->dateStartFilter) . ' - ' . dateFormat($request->dateEndFilter) . ' .pdf');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
