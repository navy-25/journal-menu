<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Note;
use App\Models\Sales;
use App\Models\SalesGroup;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = SalesGroup::all();
        foreach ($datas as $key => $value) {
            $value->update([
                'id_user' => Auth::user()->id,
            ]);
        }

        $page = 'Menu';
        $data = Menu::orderBy('id', 'DESC')->where('id_user', Auth::user()->id)->get();
        return view('menu', compact('data', 'page'));
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
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'hpp'       => 'required',
                'price'     => 'required',
            ],
        );
        $data = Menu::find($request->id);
        $data->update([
            'name'      => $request->name,
            'price'     => str_to_int($request->price),
            'hpp'       => str_to_int($request->hpp),
            'id_user'   => Auth::user()->id,
        ]);
        return redirect()->back()->with('success', 'memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
