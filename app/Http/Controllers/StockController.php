<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Bahan';
        $data = Stock::orderBy('id', 'ASC')->whereIn('id', [1, 2, 18, 20])->get();
        return view('stock', compact('data', 'page'));
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
        // $this->validate(
        //     $request,
        //     [
        //         'name'      => 'required',
        //         'qty'       => 'required|integer',
        //         'unit'      => 'required',
        //         'qty_usage' => 'required|integer',
        //     ],
        // );
        // $data = Stock::create([
        //     'name'      => $request->name,
        //     'qty'       => $request->qty,
        //     'unit'      => $request->unit,
        //     'qty_usage' => $request->qty_usage,
        // ]);
        // return redirect()->back()->with('success', 'menambahkan bahan ' . $request->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'qty'       => 'required|integer|max:9999999',
                'unit'      => 'required',
                'qty_usage' => 'required|integer|max:9999999',
            ],
        );
        $data = Stock::find($request->id);
        $data->update([
            'name'      => $request->name,
            'qty'       => $request->qty,
            'unit'      => $request->unit,
            'qty_usage' => $request->qty_usage,
        ]);
        return redirect()->back()->with('success', 'memperbarui bahan ' . $request->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock, Request $request)
    {
        // $data = Stock::find($request->id);
        // $data->delete();
        // return redirect()->back()->with('success', 'mennghapus bahan ' . $request->name);
    }
}
