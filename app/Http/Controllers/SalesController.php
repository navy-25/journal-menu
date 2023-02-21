<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sales;
use App\Models\SalesGroup;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $page = 'Penjualan';
        $menu = Menu::orderBy('name', 'DESC')->get();
        $data = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->leftJoin('sales_groups as g', 'g.id', 'sales.sales_group_id')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'g.note',
            );

        if (isset($request->dateFilter)) {
            $data = $data->where('sales.date', $request->dateFilter);
        } else {
            $data = $data->where('sales.date', date('Y-m-d'));
        }

        $data = $data
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy('sales_group_id');

        $total = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );

        if (isset($request->dateFilter)) {
            $total = $total->where('sales.date', $request->dateFilter);
        } else {
            $total = $total->where('sales.date', date('Y-m-d'));
        }

        $total = $total->sum(DB::raw('price * qty'));

        $qty = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );

        if (isset($request->dateFilter)) {
            $qty = $qty->where('sales.date', $request->dateFilter);
        } else {
            $qty = $qty->where('sales.date', date('Y-m-d'));
        }

        $qty = $qty->sum('qty');

        $isClosed = Transaction::where('date', date('Y-m-d'))->where('name', 'Tutup buku')->count();
        return view('sales', compact('data', 'page', 'menu', 'total', 'qty', 'isClosed'));
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
        date_default_timezone_set('Asia/Jakarta');

        $sales_group = SalesGroup::create([
            'name'  => '',
            'date'  => date('Y-m-d'),
            'time'  => date('H:i:s'),
            'note'  => $request->note,
        ]);

        foreach ($menu_id as $key => $menu_id) {
            if ($qty[$key] == 0) {
                continue;
            }
            $sales = Sales::create([
                'id_menu' => $menu_id,
                'qty' => $qty[$key],
                'date' => date('Y-m-d'),
                'sales_group_id' => $sales_group->id,
            ]);

            for ($i = 0; $i < $qty[$key]; $i++) {
                $list = [1, 20]; // ROTI DAN KOTAK
                foreach ($list as $key => $value) {
                    minStock($value, $sales->qty);
                }
            }
            $qty_order++;
        }
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $qty_order . ' pesanan baru');
    }
    public function migrate()
    {
        $total = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->where('date', date('Y-m-d'))
            ->sum(DB::raw('sales.qty * m.price'));
        Transaction::create([
            'name'      => 'Tutup buku',
            'price'     => $total,
            'type'      => 6,
            'status'    => 'in',
            'note'      => 'Catatan penjualan (tutup buku harian) pizza pada tanggal ' . dateFormat(date('Y-m-d')),
            'date'      => date('Y-m-d'),
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
            ->select(
                'sales.*',
                'm.name',
                'm.price',
                'g.note',
            );
        $data = $data->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->orderBy('sales.created_at', 'DESC')
            ->get()
            ->groupBy('sales_group_id');

        $total = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );

        $total = $total->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])->sum(DB::raw('price * qty'));
        $qty = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );
        $qty = $qty->whereBetween('sales.date', [$dates['dateStartFilter'], $dates['dateEndFilter']])->sum('qty');
        return view('salesDetail', compact('page', 'data', 'dates', 'total', 'qty'));
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
        $sales = Sales::where('sales_group_id', $data->id)->get();
        for ($i = 0; $i < count($sales); $i++) {
            $list = [1, 20]; // ROTI DAN KOTAK
            foreach ($list as $key => $value) {
                minStock($value, $sales[$i]->qty);
            }
            Sales::find($sales[$i]->id)->delete();
        }
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
