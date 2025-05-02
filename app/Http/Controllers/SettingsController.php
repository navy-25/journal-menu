<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

date_default_timezone_set('Asia/Jakarta');
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Settings';

        $stock_menu = [
            [
                'name'  => 'Menu',
                'route' => route('menu.index'),
                'icon'  => 'coffee',
            ],
            // [
            //     'name'  => 'Bahan',
            //     'route' => route('stock.index'),
            //     'icon'  => 'package',
            // ],
            // [
            //     'name'  => 'Harga Bahan',
            //     'route' => route('material.index'),
            //     'icon'  => 'book',
            // ],
        ];
        $account = [
            [
                'name'  => 'Akun',
                'route' => route('account.index'),
                'icon'  => 'user',
            ],
            [
                'name'  => 'Kata sandi',
                'route' => route('account.password'),
                'icon'  => 'key',
            ],
        ];
        $more = [
            // [
            //     'name'  => 'Laporan',
            //     'route' => route('report.index'),
            //     'icon'  => 'printer',
            // ],
            [
                'name'  => 'Catatan',
                'route' => route('note.index'),
                'icon'  => 'file-text',
            ],
            [
                'name'  => 'S&K',
                'route' => '#',
                'icon'  => 'file-text',
            ],
        ];
        return view('settings', compact('page', 'stock_menu', 'more', 'account'));
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
