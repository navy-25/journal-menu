<?php

namespace App\Http\Controllers;

use App\Models\Spend;
use Illuminate\Http\Request;



class SpendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Pengeluaran';
        $data = Spend::query();

        if (isset($request->dateFilter)) {
            $data = $data->where('spends.date', $request->dateFilter);
        } else {
            $data = $data->where('spends.date', date('Y-m-d'));
        }

        $data = $data->orderBy('spends.created_at', 'DESC')->get();

        $total = Spend::query();

        if (isset($request->dateFilter)) {
            $total = $total->where('spends.date', $request->dateFilter);
        } else {
            $total = $total->where('spends.date', date('Y-m-d'));
        }

        $total = $total->sum('price');
        return view('spend', compact('data', 'page', 'total'));
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
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'price'     => 'required|integer|max:9999999',
                'type'      => 'required|integer',
            ],
        );
        $data = Spend::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'note' => $request->note,
            'date' => date('Y-m-d'),
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function show(Spend $spend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function edit(Spend $spend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spend $spend)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'price'     => 'required|integer|max:9999999',
                'type'      => 'required|integer',
            ],
        );
        $data = Spend::find($request->id);
        $data->update([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'note' => $request->note,
            'date' => date('Y-m-d'),
        ]);
        return redirect()->back()->with('success', 'berhasil memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Spend  $spend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spend $spend, Request $request)
    {
        $data = Spend::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'dihapus');
    }
}
