<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Penjualan';
        $menu = Menu::orderBy('name', 'ASC')->get();
        $data = Sales::query()
            ->join('menus as m', 'm.id', 'sales.id_menu')
            ->select(
                'sales.*',
                'm.name',
                'm.price',
            );

        if (isset($request->dateFilter)) {
            $data = $data->where('sales.date', $request->dateFilter);   
        }

        $data = $data->orderBy('sales.created_at', 'DESC')->get();
        return view('sales', compact('data', 'page', 'menu'));
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
        date_default_timezone_set('Asia/Jakarta');
        Sales::create([
            'id_menu' => $request->id_menu,
            'qty' => $request->qty,
            'date' => date('Y-m-d'),
        ]);

        return redirect()->back()->with('success', 'Berhasil');
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
        $data->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus');
    }
}
