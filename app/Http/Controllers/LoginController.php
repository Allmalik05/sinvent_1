<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function index() {
        return view('login');
    }

    public function authenticate(Request $request) {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        if (Auth::attempt($credentials)) {
            return redirect()->intended('barang')->with('success', 'Login Success.');
        }

        return back()->with('error', 'Error Email or Password');

    }

    public function logout(Request $request): RedirectResponse
        {

        Auth::logout();

        return redirect()->route('login')->with('success', 'Logout Berhasil.');
    }
}
