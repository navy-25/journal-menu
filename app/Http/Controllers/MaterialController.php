<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Harga Bahan';
        $data = Material::orderBy('name', 'ASC')->where('id_user', getUserID())->get();
        return view('material', compact('data', 'page'));
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
                'merk'      => 'required',
                'price'     => 'required',
                'shop'      => 'required',
            ],
        );
        $data = Material::create([
            'name'      => $request->name,
            'price'     => str_to_int($request->price),
            'merk'      => $request->merk,
            'id_user'   => getUserID(),
            'shop'      => $request->shop,
        ]);
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $this->validate(
            $request,
            [
                'id'        => 'required',
                'name'      => 'required',
                'merk'      => 'required',
                'price'     => 'required',
                'shop'      => 'required',
            ],
        );
        $data = Material::find($request->id);
        $data->update([
            'name'      => $request->name,
            'price'     => str_to_int($request->price),
            'merk'      => $request->merk,
            'id_user'   => getUserID(),
            'shop'      => $request->shop,
        ]);
        return redirect()->back()->with('success', 'memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Material $material)
    {
        $data = Material::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');
    }

}
