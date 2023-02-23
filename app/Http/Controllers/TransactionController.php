<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');

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
        if (isset($request->dateFilter)) {
            $dateFilter = $request->dateFilter;
        } else {
            $dateFilter = date('Y-m-d');
        }

        $data = Transaction::query()
            ->where('transactions.date', $dateFilter)
            ->orderBy('transactions.created_at', 'DESC')->get();

        $income = Transaction::query()
            ->where('transactions.date', $dateFilter)
            ->where('status', 'in')->sum('price');

        $outcome = Transaction::query()
            ->where('transactions.date', $dateFilter)
            ->where('status', 'out')->sum('price');

        return view('transaction', compact(
            'page',
            'data',
            'outcome',
            'income',
            'dateFilter'
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
                'date'      => 'required',
                'status'    => 'required',
                'price'     => 'required',
                'type'      => 'required|integer',
            ],
        );
        $data = Transaction::create([
            'name'      => $request->name,
            'price'     => str_to_int($request->price),
            'type'      => $request->type,
            'status'    => $request->status,
            'note'      => $request->note,
            'date'      => $request->date,
        ]);
        return redirect()->route('transaction.index', ['dateFilter' => $request->date])->with('success', 'berhasil menambahkan ' . $data->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction, Request $request)
    {
        if ($request->all() == []) {
            $dates['dateEndFilter']      = date('Y-m-d');
            $dates['dateStartFilter']    = date('Y-m-d', strtotime('-1 month', strtotime($dates['dateEndFilter'])));
        } else {
            $dates['dateEndFilter']      = $request->dateEndFilter;
            $dates['dateStartFilter']    = $request->dateStartFilter;
        }

        if ($request->order == null) {
            $orderFilter = 'date';
        } else {
            $orderFilter = $request->order;
        }
        if ($request->type == 0) {
            $type       = [1, 2, 3, 4, 5, 6];
            $typeFilter = 0;
        } else {
            $type       = [$request->type];
            $typeFilter = $request->type;
        }
        $page = 'Detail transaksi';
        $data = Transaction::query()
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereIn('type', $type)
            ->orderBy($orderFilter, 'DESC')
            ->get();
        $income = Transaction::query()
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereIn('type', $type)
            ->where('status', 'in')->sum('price');

        $outcome = Transaction::query()
            ->whereBetween('date', [$dates['dateStartFilter'], $dates['dateEndFilter']])
            ->whereIn('type', $type)
            ->where('status', 'out')->sum('price');
        return view('transactionDetail', compact('page', 'data', 'dates', 'income', 'outcome', 'orderFilter', 'typeFilter'));
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
                'date'      => 'required',
            ],
        );
        $data = Transaction::find($request->id);
        $data->update([
            'name'      => $request->name,
            'price'     => str_to_int($request->price),
            'type'      => $request->type,
            'note'      => $request->note,
            'status'    => $request->status,
            'date'      => $request->date,
        ]);
        return redirect()->route('transaction.index', ['dateFilter' => $request->date])->with('success', 'berhasil memperbarui ' . $data->name);
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
