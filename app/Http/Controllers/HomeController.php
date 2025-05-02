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
        $page = 'Home';
        $dates['dateEndFilter']      = date('Y-m-t');
        $dates['dateStartFilter']    = date('Y-m-01');

        $trans_in_this_month = Transaction::where('status', 'in')
            ->where('transactions.id_user', getUserID())
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');
        $trans_out_this_month = Transaction::where('status', 'out')
            ->where('transactions.id_user', getUserID())
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('price');

        $data['month'] = $trans_in_this_month;
        $data['sisa'] = $trans_in_this_month - $trans_out_this_month;

        $menu = [
            [
                'name'      => 'Statistik',
                'icon'      => asset('app-assets/images/data-analysis.webp'),
                'route'     => 'stats.index',
                'access'    => [1,2]
            ],
            [
                'name'      => 'Keuangan',
                'icon'      => asset('app-assets/images/accounting.webp'),
                'route'     => 'transaction.index',
                'access'    => [1,2]
            ],
            [
                'name'      => 'Kasir',
                'icon'      => asset('app-assets/images/approved-order.webp'),
                'route'     => 'sales.index',
                'access'    => [1,2]
            ],
            [
                'name'      => 'Menu',
                'icon'      => asset('app-assets/images/pizza-slice.webp'),
                'route'     => 'menu.index',
                'access'    => [1]
            ],
            // [
            //     'name'      => 'Bahan',
            //     'icon'      => asset('app-assets/images/rolling-pin.webp'),
            //     'route'     => 'stock.index',
            //     'access'    => [1]
            // ],
            [
                'name'      => 'Katalog',
                'icon'      => asset('app-assets/images/package.webp'),
                'route'     => 'material.index',
                'access'    => [1]
            ],
            // [
            //     'name'      => 'Laporan',
            //     'icon'      => asset('app-assets/images/folder.webp'),
            //     'route'     => 'report.index',
            //     'access'    => [1,2]
            // ],
            [
                'name'      => 'Laba Kotor',
                'icon'      => asset('app-assets/images/investment-growth.webp'),
                'route'     => 'profit.index',
                'access'    => [1]
            ],
            [
                'name'      => 'Catatan',
                'icon'      => asset('app-assets/images/book.webp'),
                'route'     => 'note.index',
                'access'    => [1,2]
            ],
            // [
            //     'name'      => 'Akun',
            //     'icon'      => asset('app-assets/images/data-analysis.webp'),
            //     'route'     => 'account.index',
            //     'access'    => [1,2]
            // ],
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
