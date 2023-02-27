<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        $page = 'Login';
        return view('auth.login', compact('page'));
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'phone'     => 'required',
                'password'  => 'required',
            ],
            [
                'required'  => ':attribute tidak boleh kosong',
            ],
            [
                'phone'     => 'nomor telepon',
                'password'  => 'kata sandi',
            ]
        );
        $user = User::where('phone', $request->phone)->first();
        if ($user == null) {
            return redirect()->back()->with('error', 'nomor telepon salah');
        } else {
            $status = $user->status;
            if ($status == 0) {
                return redirect()->back()->with('error', 'akun anda di bekukan');
            }
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('stats.index'))->with('success', 'Berhasil Login');
        }
        return redirect()->back()->with('error', 'Kata sandi anda salah');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->back()->with('success', 'Berhasil keluar aplikasi');
    }
}
