<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sales;
use App\Models\SalesGroup;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Jakarta');
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->dateFilter)) {
            $dateFilter = $request->dateFilter;
        } else {
            $dateFilter = date('Y-m-d');
        }

        $page = 'Penjualan';
        $menu = Menu::orderBy('name', 'DESC')->where('id_user', Auth::user()->id)->get();
        $data = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->leftJoin('sales_groups as g', 'g.id', 'sales.sales_group_id')
            ->where('sales.date', $dateFilter)
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
                'g.note',
            )
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy('sales_group_id');

        $total = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.date', $dateFilter)
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
            )->sum(DB::raw('gross_profit * qty'));

        $qty = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.date', $dateFilter)
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
            )
            ->sum('qty');

        $isClosed = Transaction::query()
            ->where('transactions.date', $dateFilter)
            ->where('name', 'LIKE', "%Tutup Buku%")
            ->where('transactions.id_user', Auth::user()->id)
            ->count();
        return view('sales', compact('data', 'page', 'menu', 'total', 'qty', 'isClosed', 'dateFilter'));
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
        $menu_id    = $request->menu_id;
        $qty        = $request->qty;
        if (array_sum($qty) == 0) {
            return redirect()->route('sales.index')->with('error', 'oops, belum ada menu yang dipilih');
        }
        $qty_order  = 0;
        $sales_group = SalesGroup::create([
            'name'          => '',
            'date'          => date('Y-m-d'),
            'time'          => date('H:i:s'),
            'note'          => $request->note,
            'id_user'       => Auth::user()->id,
        ]);
        $stock = Stock::where('id_user', Auth::user()->id)->get();
        foreach ($menu_id as $key => $menu_id) {
            $menu = Menu::find($menu_id);
            if ($qty[$key] == 0) {
                continue;
            }
            $sales = Sales::create([
                'id_menu'           => $menu->id,
                'id_user'           => Auth::user()->id,
                'qty'               => $qty[$key],
                'date'              => date('Y-m-d'),
                'sales_group_id'    => $sales_group->id,
                'gross_profit'      => $menu->price,
                'net_profit'        => $menu->hpp,
            ]);

            foreach ($stock as $value) {
                minStock($value->id, $sales->qty);
            }
            $qty_order++;
        }
        // dd($list);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $qty_order . ' pesanan baru');
    }
    public function migrate(Request $request)
    {
        if (isset($request->dateFilter)) {
            $dateFilter = $request->dateFilter;
        } else {
            $dateFilter = date('Y-m-d');
        }

        $total_kotor = Sales::query()
            ->where('date', $dateFilter)
            ->where('id_user', Auth::user()->id)
            ->sum(DB::raw('qty * gross_profit'));
        $total_bersih = Sales::query()
            ->where('date', $dateFilter)
            ->where('id_user', Auth::user()->id)
            ->sum(DB::raw('qty * net_profit'));

        if ($total_kotor == 0) {
            return redirect()->back()->with('error', 'Belum ada penjualan hari ini');
        }

        Transaction::create([
            'name'      => 'Tutup buku ' . customDate($dateFilter, 'd M'),
            'price'     => $total_kotor,
            'type'      => 6,
            'id_user'   => Auth::user()->id,
            'status'    => 'in',
            'note'      => 'Laba kotor : IDR ' . numberFormat($total_kotor, 0) . ', Laba bersih : IDR ' . numberFormat($total_bersih, 0),
            'date'      => $dateFilter,
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan data penjualan hari ini (Tutup buku harian)');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales, Request $request)
    {
        if ($request->all() == []) {
            $dates['dateEndFilter']      = date('Y-m-d');
            $dates['dateStartFilter']    = date('Y-m-d', strtotime('-1 month', strtotime($dates['dateEndFilter'])));
        } else {
            $dates['dateEndFilter']      = $request->dateEndFilter;
            $dates['dateStartFilter']    = $request->dateStartFilter;
        }
        $page = 'Detail penjualan';

        $data = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->leftJoin('sales_groups as g', 'g.id', 'sales.sales_group_id')
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'g.note',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy('sales_group_id');

        $gross_profit = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum(DB::raw('price * qty'));

        $net_profit = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'm.hpp',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum(DB::raw('(price-hpp) * qty'));

        $qty = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('sales.id_user', Auth::user()->id)
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            )
            ->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->sum('qty');
        return view('salesDetail', compact('page', 'data', 'dates', 'gross_profit', 'qty', 'net_profit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sales, Request $request)
    {
        $data = SalesGroup::find($request->id);
        $sales = Sales::where('sales_group_id', $data->id)->where('id_user', Auth::user()->id)->get();

        $stock = Stock::where('id_user', Auth::user()->id)->get();
        foreach ($sales as $value) {
            foreach ($stock as $val) {
                plusStock($val->id, $value->qty);
            }
        }
        $sales = Sales::where('sales_group_id', $data->id)->where('id_user', Auth::user()->id)->delete();
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
