<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Note;
use App\Models\Sales;
use App\Models\SalesGroup;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Pengguna';
        $data = User::orderBy('id', 'DESC')->whereNot('id', Auth::user()->id)->get();
        return view('developer.users', compact('page', 'data'));
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
                'phone'     => 'required',
                'address'   => 'required',
                'role'      => 'required',
                'status'    => 'required',
                'owner'     => 'required',
                'email'     => 'required',
                'password'  => 'required',
            ],
        );
        $data = User::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'role'      => $request->role,
            'status'    => $request->status,
            'owner'     => $request->owner,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        $menu   = ['choco strawberry', 'choco vanilla', 'choco greentea', 'choco mix', 'choco cheese', 'choco oreo', 'sosis', 'sosis keju', 'sosis mozzarella', 'super mozzarella komplit', 'special ayam mozzarella', 'smoke beef mozzarella', 'meat lovers', 'papperoni mozzarella',];
        $hpp    = [6300, 6300, 6300, 6465, 7800, 7700, 6600, 8100, 9100, 9390, 11200, 10800, 10800, 10800,];
        $price  = [10000, 10000, 10000, 11000, 15000, 15000, 10000, 15000, 15000, 15000, 20000, 18000, 18000, 18000,];
        foreach ($menu as $key => $value) {
            Menu::create([
                'name'      => $value,
                'price'     => $price[$key],
                'hpp'       => $hpp[$key],
                'id_user'   => $data->id
            ]);
        }


        $name = [
            'Roti',
            // 'Saus Pasta',
            // 'Sosis',
            // 'Papperoni',
            // 'Beef',
            // 'Oreo',
            // 'Glaze Coklat',
            // 'Glaze Strawberry',
            // 'Glaze Vanilla',
            // 'Glaze Greentea',
            // 'Meses',
            // 'Keju',
            // 'Saus Keju',
            // 'Mozarella',
            // 'Saus Tomat',
            // 'Saus Pedas',
            // 'Mayonise',
            // 'Margarin',
            // 'Saus Sachetan',
            'Kotak Pizza',
        ];

        foreach ($name as $key => $value) {
            Stock::create([
                'id'        => ++$key,
                'name'      => $value,
                'qty'       => 0,
                'unit'      => '',
                'qty_usage' => 0,
                'id_user'   => $data->id,
            ]);
        }
        return redirect()->back()->with('success', 'berhasil menambahkan ' . $data->name);
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
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'phone'     => 'required',
                'address'   => 'required',
                'role'      => 'required',
                'status'    => 'required',
                'owner'     => 'required',
                'email'     => 'required',
            ],
        );
        $data = User::find($request->id);
        $data->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'role'      => $request->role,
            'status'    => $request->status,
            'owner'     => $request->owner,
            'email'     => $request->email,
        ]);

        if ($request->password) {
            $data->update([
                'password'  => Hash::make($request->password),
            ]);
        }
        return redirect()->back()->with('success', 'berhasil memperbarui ' . $data->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::find($request->id)->delete();
        Sales::where('id_user', $request->id)->delete();
        Transaction::where('id_user', $request->id)->delete();
        Menu::where('id_user', $request->id)->delete();
        Stock::where('id_user', $request->id)->delete();
        Note::where('id_user', $request->id)->delete();
        SalesGroup::where('id_user', $request->id)->delete();
        return redirect()->back()->with('success', 'akun berhasil dihapus');
    }
}
