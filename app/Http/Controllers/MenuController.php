<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Jakarta');
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Menu';
        $data = Menu::orderBy('id', 'DESC')->where('id_user', getUserID())->get();
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
        $this->validate(
            $request,
            [
                'name'          => 'required',
                'hpp'           => 'required',
                'price'         => 'required',
                'is_promo'      => 'required',
                'status'        => 'required',
            ],
        );
        if ($request->is_promo == 1) {
            if ($request->price_promo == null || $request->price_promo == '') {
                return redirect()->back()->with('error', 'harga promo belum di isi');
            }
        }
        $data = Menu::create([
            'name'          => $request->name,
            'price'         => str_to_int($request->price),
            'hpp'           => str_to_int($request->hpp),
            'id_user'       => getUserID(),
            'is_promo'      => $request->is_promo,
            'price_promo'   => str_to_int($request->price_promo),
            'status'        => $request->status,
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->name);
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
                'name'          => 'required',
                'hpp'           => 'required',
                'price'         => 'required',
                'is_promo'      => 'required',
                'status'        => 'required',
            ],
        );
        $data = Menu::find($request->id);
        if ($request->is_promo == 1) {
            if ($request->price_promo == null || $request->price_promo == '') {
                return redirect()->back()->with('error', 'harga promo belum di isi');
            }
        }
        $data->update([
            'name'          => $request->name,
            'price'         => str_to_int($request->price),
            'hpp'           => str_to_int($request->hpp),
            'id_user'       => getUserID(),
            'is_promo'      => $request->is_promo,
            'price_promo'   => str_to_int($request->price_promo),
            'status'        => $request->status,
        ]);
        return redirect()->back()->with('success', 'memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $data = Menu::find($request->id);
        $is_used = Sales::where('id_user', getUserID())->where('id_menu', $data->id)->count();
        if ($is_used > 0) {
            return redirect()->back()->with('error', 'data masih digunakan');
        }
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }
}
