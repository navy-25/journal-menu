<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
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
        return redirect()->back()->with('success', 'akun berhasil dihapus');
    }
}
