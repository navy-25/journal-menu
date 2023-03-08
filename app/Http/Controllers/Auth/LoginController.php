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

        if (isset(Auth::user()->id) == true) {
            $role = Auth::user()->role;
            if ($role == 0) {
                return redirect()->route('dev.home.index');
            } else if ($role == 1) {
            } else {
                return redirect()->route('stats.index');
            }
        } else {
            return view('auth.login', compact('page'));
        }
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
            $auth = Auth::user();
            if ($auth->role == 0) {
                return redirect()->intended(route('dev.user.index'))->with('success', 'Berhasil Login');
            } else if ($auth->role == 1) {
                dd('sedang di develop');
            } else {
                return redirect()->intended(route('stats.index'))->with('success', 'Berhasil Login');
            }
        }
        return redirect()->back()->with('error', 'Kata sandi anda salah');
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login.form')->with('success', 'Berhasil keluar aplikasi');
    }
}
