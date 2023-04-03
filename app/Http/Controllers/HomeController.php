<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Beranda';
        $dates['dateEndFilter']      = date('Y-m-t');
        $dates['dateStartFilter']    = date('Y-m-01');
        $trans_outcome = Transaction::where('status', 'out')
            ->where('transactions.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');
        $trans_intcome = Transaction::where('status', 'in')
            ->where('transactions.id_user', Auth::user()->id)
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');

        $data['month'] = $trans_intcome - $trans_outcome;

        $trans_outcome = Transaction::where('status', 'out')
            ->where('transactions.id_user', Auth::user()->id)
            ->sum('price');
        $trans_intcome = Transaction::where('status', 'in')
            ->where('transactions.id_user', Auth::user()->id)
            ->sum('price');
        $data['all'] = $trans_intcome - $trans_outcome;

        $menu = [
            [
                'name'      => 'Statistik',
                'icon'      => 'pie-chart',
                'route'     => 'stats.index',
            ],
            [
                'name'      => 'Kasir',
                'icon'      => 'shopping-cart',
                'route'     => 'sales.index',
            ],
            [
                'name'      => 'Keuangan',
                'icon'      => 'repeat',
                'route'     => 'transaction.index',
            ],
            [
                'name'      => 'Menu',
                'icon'      => 'coffee',
                'route'     => 'menu.index',
            ],
            [
                'name'      => 'Bahan',
                'icon'      => 'box',
                'route'     => 'stock.index',
            ],
            [
                'name'      => 'Laporan',
                'icon'      => 'printer',
                'route'     => 'report.index',
            ],
            [
                'name'      => 'Catatan',
                'icon'      => 'file',
                'route'     => 'note.index',
            ],
            [
                'name'      => 'Akun',
                'icon'      => 'user',
                'route'     => 'account.index',
            ],
        ];
        return view('home', compact('data', 'page', 'dates', 'menu'));
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
