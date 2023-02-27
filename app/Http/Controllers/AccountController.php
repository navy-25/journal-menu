<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = 'Akun';
        return view('account', compact('page'));
    }
    public function password()
    {
        $page = 'Kata sandi';
        return view('password', compact('page'));
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
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        $this->validate(
            $request,
            [
                'phone'     => 'required',
                'owner'     => 'required',
                'address'   => 'required',
            ],
        );
        $data = User::find(Auth::user()->id);
        $data->update([
            'phone'     => $request->phone,
            'owner'     => $request->owner,
            'address'   => $request->address,
        ]);
        return redirect()->back()->with('success', 'berhasil memperbarui akun');
    }
    public function updatePassword(Request $request, Account $account)
    {
        $this->validate(
            $request,
            [
                'password'              => 'required',
                'retype_password'       => 'required',
            ],
        );
        if ($request->password != $request->retype_password) {
            return redirect()->back()->with('error', 'kata sandi tidak cocok');
        }
        $data = User::find(Auth::user()->id);
        $data->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back()->with('success', 'berhasil memperbarui kata sandi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
