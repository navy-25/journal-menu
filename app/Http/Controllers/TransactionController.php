<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Transaksi';
        $data = Transaction::query();

        if (isset($request->dateFilter)) {
            $data = $data->where('transactions.date', $request->dateFilter);
        } else {
            $data = $data->where('transactions.date', date('Y-m-d'));
        }

        $data = $data->orderBy('transactions.created_at', 'DESC')->get();

        $income = Transaction::query();
        if (isset($request->dateFilter)) {
            $income = $income->where('transactions.date', $request->dateFilter);
        } else {
            $income = $income->where('transactions.date', date('Y-m-d'));
        }
        $income = $income->where('status', 'in')->sum('price');

        $outcome = Transaction::query();
        if (isset($request->dateFilter)) {
            $outcome = $outcome->where('transactions.date', $request->dateFilter);
        } else {
            $outcome = $outcome->where('transactions.date', date('Y-m-d'));
        }
        $outcome = $outcome->where('status', 'out')->sum('price');

        return view('transaction', compact(
            'page',
            'data',
            'outcome',
            'income',
        ));
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
                'status'    => 'required',
                'price'     => 'required',
                'type'      => 'required|integer',
            ],
        );
        $data = Transaction::create([
            'name'      => $request->name,
            'price'     => str_replace('.', '', $request->price),
            'type'      => $request->type,
            'status'    => $request->status,
            'note'      => $request->note,
            'date'      => date('Y-m-d'),
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'price'     => 'required',
                'type'      => 'required|integer',
                'status'    => 'required',
            ],
        );
        $data = Transaction::find($request->id);
        $data->update([
            'name'      => $request->name,
            'price'     => str_replace('.', '', $request->price),
            'type'      => $request->type,
            'note'      => $request->note,
            'status'    => $request->status,
            'date'      => date('Y-m-d'),
        ]);
        return redirect()->back()->with('success', 'berhasil memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $data = Transaction::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
