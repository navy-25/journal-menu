<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sales;
use App\Models\Stock;
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
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );

        if (isset($request->dateFilter)) {
            $data = $data->where('sales.date', $request->dateFilter);
        } else {
            $data = $data->where('sales.date', date('Y-m-d'));
        }

        $data = $data->orderBy('sales.created_at', 'DESC')->get();

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
        return view('sales', compact('data', 'page', 'menu', 'total', 'qty'));
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
        foreach ($menu_id as $key => $menu_id) {
            if ($qty[$key] == 0) {
                continue;
            }
            Sales::create([
                'id_menu' => $menu_id,
                'qty' => $qty[$key],
                'date' => date('Y-m-d'),
            ]);

            for ($i = 0; $i < $qty[$key]; $i++) {
                $list = [1, 20]; // ROTI DAN KOTAK
                foreach ($list as $key => $value) {
                    minStock($value);
                }
            }
            $qty_order++;
        }
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $qty_order . ' pesanan baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
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
        $data = Sales::find($request->id);

        for ($i = 0; $i < $data->qty; $i++) {
            $list = [1, 20]; // ROTI DAN KOTAK
            foreach ($list as $key => $value) {
                minStock($value);
            }
        }
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
